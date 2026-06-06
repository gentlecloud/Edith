<?php

namespace Edith\Admin\Console;

use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Models\EdithConfig;
use Edith\Admin\Support\Rsa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'edith:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the edith version';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->call('migrate');
        $this->addWildcardRoute();
        $this->deleteHomeController();
        EdithConfig::where('name', 'WEB_SITE_LOGO')->update([
            'type' => 'uploader'
        ]);
        modify_env(['EDITH_VERSION' => EdithAdmin::version()]);
        if (version_compare(EdithAdmin::version(), '2.0.9', '<=')) {
            $this->generateConfig();
            $this->laravel['files']->deleteDirectory(resource_path('views/edith/edith'));
        }
    }

    /**
     * @return void
     */
    protected function addWildcardRoute()
    {
        $routesFile = base_path('/routes/web.php');
        $content = $this->laravel['files']->get($routesFile);

        if (str_contains($content, "Route::get('/{any}'")) {
            return;
        }

        // 检查默认的 welcome 路由并替换
        if (str_contains($content, "view('welcome')")) {
            $content = str_replace("view('welcome')", "view('edith.index')", $content);
        }
        $this->laravel['files']->put($routesFile, $content);
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function generateConfig()
    {
        $content = $this->getStub('edith-config');
        $file = base_path('/config/edith.php');
        // 初始化Token相关
        if (file_exists($file)) {
            $rsaInfo = [
                'public_key' => config('edith.rsa.public_key'),
                'private_key' => config('edith.rsa.private_key'),
            ];
        }
        if (!file_exists($file) || empty($rsaInfo['public_key']) || empty($rsaInfo['private_key'])) {
            $rsaInfo = (new Rsa())->generate();
        }

        $content = str_replace('{{public_key}}', $rsaInfo['public_key'], $content);
        $content = str_replace('{{private_key}}', $rsaInfo['private_key'], $content);

        $this->laravel['files']->put($file, $content);
    }

    /**
     * @return void
     */
    protected function deleteHomeController()
    {
        $this->directory = app_path('Edith/Controllers');
        $controller = $this->directory . '/HomeController.php';
        if (file_exists($controller)) {
            $this->laravel['files']->delete($controller);
        }
    }

    /**
     * Get stub contents.
     * @param $name
     * @return string
     */
    protected function getStub($name): string
    {
        return $this->laravel['files']->get(__DIR__."/stubs/$name.stub");
    }
}