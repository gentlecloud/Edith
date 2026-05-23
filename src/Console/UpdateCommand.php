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
     */
    public function handle()
    {
        $this->call('migrate');
        if (version_compare(ltrim(env('EDITH_VERSION', '1.0.0'), 'v'), '2.0.1', '<=') || empty(config('edith.rsa.public_key'))) {
            $this->updateAdminRsaKey();
        }
        $this->createHomeController();
        EdithConfig::where('name', 'WEB_SITE_LOGO')->update([
            'type' => 'uploader'
        ]);
        modify_env(['EDITH_VERSION' => EdithAdmin::version()]);
    }

    /**
     * @return void
     */
    public function createHomeController()
    {
        $this->directory = app_path('Edith/Controllers');
        $controller = $this->directory . '/HomeController.php';
        if (!file_exists($controller)) {
            $contents = $this->getStub('HomeController');

            $this->laravel['files']->put($controller, $contents);
        }
    }

    /**
     * @return void
     */
    public function updateAdminRsaKey()
    {
        try {
            $rsaInfo = (new Rsa())->generate();
            modify_config_file('edith.php', 'rsa', $rsaInfo);
        } catch (\Exception $e) {
            Log::error("Edith Admin install Failed. Init Rsa ErrMsg:" . $e->getMessage());
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