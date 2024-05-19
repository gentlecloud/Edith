<?php
namespace Edith\Admin\Modules;

use Edith\Admin\Contracts\EdithModuleCoreInterface;
use Edith\Admin\Contracts\EdithModuleInterface;
use Edith\Admin\Exceptions\RuntimeException;
use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Models\EdithModule;
use Edith\Admin\Support\Json;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Core implements EdithModuleCoreInterface
{
    /**
     * @var Container
     */
    protected Container $app;

    /**
     * @var ConfigRepository
     */
    private ConfigRepository $config;

    /**
     * @var ServiceProvider[]|Collection
     */
    protected Collection $modules;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var string
     */
    protected string $path;

    /**
     * The constructor.
     * @param Container $app
     * @param string $name
     * @param string $path
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->modules = new Collection();
        $this->config = $app['config'];
        $this->files = $app['files'];
        $this->path = $app['config']->get('edith.modules.path', base_path('modules'));
    }

    /**
     * 注册模块
     * @throws \Exception
     */
    public function register(): void
    {
        if (env('EDITH_INSTALL') == true && EdithAdmin::hasTable('edith_modules')) {
            $this->loadModules();
            $this->modules->each->register();
        }
    }

    /**
     * 初始化模块.
     */
    public function boot(): void
    {
        if (env('EDITH_INSTALL') == true) {
            $this->modules->each->boot();
        }
    }

    /**
     * Get the System Modules paths.
     * @return string
     */
    public function getPath(): string
    {
        $path = $this->path;
        if (!is_dir($path)) {
            return '';
        }
        return Str::finish($path, '/%s');
    }

    /**
     * Get laravel filesystem instance.
     * @return Filesystem
     */
    public function getFiles(): Filesystem
    {
        return $this->files;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function enabled(string $name): bool
    {
        return EdithModule::where('name', $name)->firstOrFail()->status == 1;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function disabled(string $name): bool
    {
        return !$this->enabled($name);
    }

    /**
     * find the quick modules
     * @param string $name
     * @param bool $install
     * @return EdithModuleInterface
     * @throws RuntimeException
     */
    public function findOrFail(string $name, bool $install = false): EdithModuleInterface
    {
        $module = $this->modules->get(strtolower($name));
        if (!$module) {
            if (!$install || !file_exists($path = sprintf($this->getPath(), $name). '/module.json')) {
                throw new RuntimeException("Modules {$name} does not exist!");
            }
            $module = $this->createModule($name, dirname($path));
        }
        return $module;
    }

    /**
     * @return array|null
     */
    public function scan(): ?array
    {
        $path = $this->getPath();
        if (!is_dir(str_replace('/%s', '', $path))) {
            return [];
        }
        $path = sprintf($this->getPath(),'*');
        $scans = $this->getFiles()->glob("{$path}");
        $modules = [];
        if (is_array($scans)) {
            foreach ($scans as $row) {
                try {
                    $name = str_replace(str_replace('%s', '',$this->getPath()), '', $row);
                    $modules[$name] = $this->findOrFail($name, true)->getVersion();
                } catch (\Exception $e) {

                }
            }
        }
        return $modules;
    }

    /**
     * load Edith Modules
     */
    protected function loadModules() {
        $modules = EdithModule::query()->where('status', 1)->select('id', 'name', 'title', 'status', 'priority', 'expired_at')->orderByDesc('priority')->get();
        foreach ($modules as $key => $module) {
            $name = $module['name'] ?? str_replace(str_replace('%s', '',$this->getPath()), '', $key);;
            $path = sprintf($this->getPath(), $name);
            if (is_dir($path)) {
                try {
                    $this->modules->put(strtolower($name), $this->createModule($name, $path));
                } catch (\Exception $e) {

                }
            }
        }
    }

    /**
     * 添加-加载模块
     * @param string $name
     * @param string $path
     * @param bool $addPsr4
     * @return EdithModuleInterface
     * @throws RuntimeException
     */
    protected function createModule(string $name, string $path, bool $addPsr4 = true): EdithModuleInterface
    {
        $psr4 = [];
        if (env('EDITH_DEV') == true && !file_exists($path . '/module.json')) {
            if (!file_exists($path . '/composer.json')) {
                throw new RuntimeException('The ' . $name . ' module configuration [module.json|composer.json] file does not exist.');
            }
            $composerProperty = new Json($path . '/composer.json');
            $psr4 = (array) $composerProperty->get('autoload.psr-4');
        } else {
            if (!file_exists($path . '/module.json')) {
                throw new RuntimeException('The ' . $name . ' module configuration [module.json] file does not exist.');
            }
            $localPath = 'src/';
            if (is_dir($path . '/' . $localPath)) {
                $psr4 = [
                    ($this->config->get('edith.modules.namespace', 'Modules\\')) . $name . "\\" => $localPath
                ];
            }
        }
        if ($addPsr4 && count($psr4)) {
            foreach ($psr4 as $namespace => $loadPath) {
                EdithAdmin::classLoader()->addPsr4($namespace, $path . '/' . $loadPath);
            }
        }
        $module = new Module($this->app, $name, $path);
        if (isset($composerProperty)) {
            $module->withComposerProperty($composerProperty);
        }
        return $module;
    }
}