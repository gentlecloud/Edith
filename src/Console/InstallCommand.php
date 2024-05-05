<?php
namespace Gentle\Edith\Console;

use Gentle\Edith\Models\Seeders\EdithSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Gentle\Edith\Models\EdithAdmin;
use Gentle\Edith\Support\FileUtils;

class InstallCommand extends Command
{
    const version = 'v1.0.0';
    /**
     * The console command name.
     * @var string
     */
    protected $signature = 'edith:install {username=admin} {password=123456} {email=edith@newly.cc}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Install the Gentle-Edith package';

    /**
     * Install directory.
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        // 初始化数据库
        $this->initDatabase();

        // 初始化Admin目录
        $this->initAdminDirectory();

        // 创建软连接
        $this->call('storage:link');

        modify_env(['EDITH_INSTALL' => true]);
        modify_env(['EDITH_VERSION' => self::version]);
        FileUtils::writeLog(base_path('install.lock'), 'Gentle_Edith install: ok');
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initDatabase()
    {

        if(env('EDITH_INSTALL') === true){
            $this->call('migrate:fresh --seed');
        } else {
            $this->call('migrate');
        }

        if (!EdithAdmin::count()) {
            $this->runDatabaseSeeders();
        }
    }

    /**
     * Initialize the admAin directory.
     *
     * @return void
     */
    protected function initAdminDirectory()
    {
        $this->directory = app_path('Edith/Controllers');

        if (is_dir($this->directory)) {
            $this->line("<error>{$this->directory} directory already exists !</error> ");

            return;
        }

        $this->makeDir('/');
        $this->line('<info>Manage directory was created:</info> '.str_replace(base_path(), '', $this->directory));

        $this->createDashboardController();
        $this->createAdminController();
        $this->createUpgradeController();
        $this->createRoutesFile();
    }

    /**
     * Create DashboardController.
     *
     * @return void
     */
    public function createDashboardController()
    {
        $controller = $this->directory . '/DashboardController.php';
        $contents = $this->getStub('DashboardController');

        $this->laravel['files']->put($controller,$contents);
        $this->line('<info>DashboardController file was created:</info> '.str_replace(base_path(), '', $controller));
    }

    /**
     * Create DashboardController.
     *
     * @return void
     */
    public function createAdminController()
    {
        $controller = $this->directory . '/AdminController.php';
        $contents = $this->getStub('AdminController');

        $this->laravel['files']->put($controller,$contents);

        $controller = $this->directory . '/AuthController.php';
        $contents = $this->getStub('AuthController');

        $this->laravel['files']->put($controller,$contents);
        $this->line('<info>AdminController and AuthController file was created:</info> '.str_replace(base_path(), '', $controller));
    }


    /**
     * Create UpgradeController.
     *
     * @return void
     */
    public function createUpgradeController()
    {
        $controller = $this->directory . '/UpgradeController.php';
        $contents = $this->getStub('UpgradeController');

        $this->laravel['files']->put($controller,$contents);
        $this->line('<info>UpgradeController file was created:</info> '.str_replace(base_path(), '', $controller));
    }

    /**
     * Create routes file.
     * @return void
     */
    protected function createRoutesFile()
    {
        $file = base_path() . '/routes/web.php';
        $contents = $this->getStub('routes');

        $this->laravel['files']->put($file, $contents);
        $this->line('<info>Routes file was created:</info> '.str_replace(base_path(), '', $file));
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

    /**
     * Make new directory.
     * @param string $path
     */
    protected function makeDir(string $path = '')
    {
        $this->laravel['files']->makeDirectory("{$this->directory}/$path", 0755, true, true);
    }

    /**
     * Run the database seeds.
     * @return void
     */
    protected function runDatabaseSeeders()
    {
        $this->call('db:seed', ['--class' => EdithSeeder::class]);
        $username = $this->argument('username');
        $password = $this->argument('password');
        $email = $this->argument('email');
        // 管理员
        EdithAdmin::create([
            'username' => $username,'nickname' => '超级管理员','email' => $email,'phone' => '10086','sex' => 1,'password' => bcrypt($password)
        ]);
    }
}