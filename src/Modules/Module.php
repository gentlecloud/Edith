<?php
namespace Edith\Admin\Modules;

use Edith\Admin\Contracts\EdithModuleInterface;
use Edith\Admin\Models\EdithModule;
use Edith\Admin\Support\File;
use Edith\Admin\Support\Json;
use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Translation\Translator;

class Module implements EdithModuleInterface
{

    use Macroable;

    /**
     * The laravel application instance.
     * @var Container
     */
    protected Container $app;

    /**
     * The module name.
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * The module path.
     * @var string|null
     */
    protected ?string $path = null;

    /**
     * @var Json|Collection
     */
    protected $moduleJson;

    /**
     * @var Json|Collection
     */
    protected $composerProperty;

    /**
     * @var Filesystem
     */
    private $files;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * The constructor.
     * @param Container $app
     * @param string $name
     * @param string $path
     * @throws \Exception
     */
    public function __construct(Container $app, string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
        $this->files = $app->files;
        $this->translator = $app->translator;
        $this->app = $app;
        $this->moduleJson = new Collection();
        $this->composerProperty = new Collection();
        if (file_exists($path . '/module.json')) {
            $this->withModuleProperty(new Json($path . '/module.json'));
        }
    }

    /**
     * Bootstrap the application events.
     * @throws \Exception
     */
    public function boot(): void
    {
        $this->registerViews();
        $this->registerTranslation();
    }

    /**
     * Register the module.
     * @throws \Exception
     */
    public function register(): void
    {

        $this->registerAliases();
        $this->registerProviders();
        $this->registerRoutes();
    }

    /**
     * Get name.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get name in lower case.
     * @return string
     */
    public function getLowerName(): string
    {
        return strtolower($this->name);
    }

    /**
     * Get name in studly case.
     * @return string
     */
    public function getStudlyName(): string
    {
        return Str::studly($this->name);
    }

    /**
     * Get name in snake case.
     * @return string
     */
    public function getSnakeName(): string
    {
        return Str::snake($this->name);
    }

    /**
     * Get description.
     * @return string
     * @throws \Exception
     */
    public function getDescription(): string
    {
        return $this->moduleJson->get('description', $this->composerProperty->get('description', $this->getName()));
    }

    /**
     * Get alias.
     * @return array
     * @throws \Exception
     */
    public function getAliases(): array
    {
        return $this->moduleJson->get('aliases', $this->composerProperty->get('extra.edith.aliases', []));
    }

    /**
     * Get priority.
     * @return int
     * @throws \Exception
     */
    public function getPriority(): int
    {
        return intval($this->moduleJson->get('priority', 0));
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->moduleJson->get('version', $this->composerProperty->get('version', '1.0.0'));
    }

    /**
     * Get module requirements.
     * @return array
     * @throws \Exception
     */
    public function getRequires(): array
    {
        return $this->moduleJson->get('requires', $this->composerProperty->get('requires', []));
    }

    /**
     * Get path.
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Set path.
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): EdithModuleInterface
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Register the service providers from this module.
     * @throws \Exception
     */
    public function registerProviders(): void
    {
        (new ProviderRepository($this->app, new Filesystem, (new File)->getCachedServicesPath($this->getSnakeName() . '_module.php')))
            ->load($this->moduleJson->get('providers', $this->composerProperty->get('extra.edith.providers', [])));
    }

    /**
     * Register the aliases from this module.
     * @throws \Exception
     */
    public function registerAliases(): void
    {
        $loader = AliasLoader::getInstance();
        foreach ($this->getAliases() as $aliasName => $aliasClass) {
            $loader->alias($aliasName, $aliasClass);
        }
    }

    /**
     * 注册路由
     * @return void
     */
    public function registerRoutes(): void
    {
        if (is_dir($this->getExtraPath('routes'))) {
            $namespace = $this->app->config->get('edith.modules.namespace', 'Modules\\') . $this->getName() . '\\Http\\Controllers';
            // 注册 API 路由
            if (is_file($this->getExtraPath('routes/api.php'))) {
                $this->app->router->prefix('api/' . $this->getLowerName())
                    ->middleware('api')
                    ->namespace($namespace)
                    ->group($this->getExtraPath('routes/api.php'));
            }
            // 注册 Web 路由
            if (is_file($this->getExtraPath('routes/web.php'))) {
                $this->app->router->middleware('web')
                    ->namespace($namespace)
                    ->group($this->getExtraPath('routes/web.php'));
            }
            // 注册 Edith Admin 后台管理路由
            if (is_file($this->getExtraPath('routes/edith.php'))) {
                $this->app->router->prefix('api')
                    ->middleware($this->app['config']->get('edith.route.middleware', ['api', 'edith.admin']))
                    ->namespace($namespace)
                    ->group($this->getExtraPath('routes/edith.php'));
            }
        }
    }

    /**
     * Get extra path.
     * @param string $path
     * @return string
     */
    public function getExtraPath(string $path) : string
    {
        return $this->getPath() . '/' . $path;
    }

    /**
     * @param Json $json
     * @return $this
     */
    public function withComposerProperty(Json $json)
    {
        $this->composerProperty = $json;
        return $this;
    }

    /**
     * @param Json $moduleProperty
     * @return $this
     */
    public function withModuleProperty(Json $moduleProperty)
    {
        $this->moduleJson = $moduleProperty;
        return $this;
    }

    /**
     * 安装模块
     * @return void
     */
    public function install(): void
    {
        $this->runMigrations();
        if (is_dir($this->getAssetPath())) {
            if (!file_exists($this->getPublishPath())) {
                $this->files->makeDirectory($this->getPublishPath(), 0755, true, true);
            }
            $this->files->copyDirectory($this->getAssetPath(), $this->getPublishPath());
        }
    }

    /**
     * 卸载模块
     * @return void
     */
    public function uninstall(): void
    {
        $this->runMigrations(true);
        $this->files->deleteDirectory($this->getPublishPath());
        EdithModule::where('name', $this->getSnakeName())->delete();
    }

    /**
     * 执行迁移
     * @param bool $uninstall
     * @return void
     */
    public function runMigrations(bool $uninstall = false): void
    {
        $path = $this->getExtraPath('database/Migrations');
        if (!is_dir($path)) {
            return;
        }

        if ($uninstall) {
            $this->app->migrator->rollback($path);
        } else {
            $this->app->migrator->run($path);
        }
    }

    /**
     * 获取资源发布路径.
     * @return string
     */
    protected function getPublishPath(): string
    {
        return public_path('modules/' . $this->getSnakeName());
    }

    /**
     * 获取静态资源路径.
     * @return string
     */
    final public function getAssetPath(): string
    {
        return $this->getExtraPath('assets/');
    }

    protected function registerViews(): void
    {
        $viewPath = $this->getExtraPath('resources/views');
        if (is_dir($viewPath)) {
            $this->app->view->addNamespace($this->getLowerName(), $viewPath);
        }
    }

    /**
     * Register module's translation.
     * @return void
     */
    protected function registerTranslation(): void
    {
        $langPath = $this->getExtraPath('resources/lang');

        is_dir($langPath) & $this->loadTranslationsFrom($langPath, $this->getLowerName());
    }

    /**
     * Register a translation file namespace.
     * @param  string  $path
     * @param  string  $namespace
     * @return void
     */
    private function loadTranslationsFrom(string $path, string $namespace): void
    {
        $this->translator->addNamespace($namespace, $path);
    }
}