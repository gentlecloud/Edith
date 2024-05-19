<?php
namespace Edith\Admin\Facades;

use Composer\Autoload\ClassLoader;
use Edith\Admin\Contracts\EdithAuthInterface;
use Edith\Admin\Contracts\EdithModuleCoreInterface;
use Edith\Admin\Modules\Core;
use Edith\Admin\Support\Context;
use Illuminate\Support\Facades\Facade;

/**
 * Edith Facade
 * @package Edith\Admin\Facades
 * @const version
 * @method static ClassLoader classLoader()                Composer 加载器
 * @method static string routerPrefix()                    Edith Router prefix
 * @method static void routes()                            Loader Edith Routers
 * @method static string version()                         Edith version
 * @method static EdithAuthInterface auth()                Edith Auth
 * @method static Context context()                        上下文管理
 * @method static EdithModuleCoreInterface modules()       模块管理
 */
class EdithAdmin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Edith\Admin\Admin::class;
    }
}
