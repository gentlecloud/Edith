<?php
namespace Edith\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Edith Facade
 * @package Edith\Admin\Facades
 * @const version
 * @method static ClassLoader classLoader()                Composer 加载器
 * @method static string routerPrefix()                    Edith Router prefix
 * @method static void routes()
 * @method static string version()
 */
class Edith extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Edith\Admin\Application::class;
    }
}
