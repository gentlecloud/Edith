<?php
namespace Gentle\Edith\Facades;

use Gentle\Edith\Contracts\EdithPlatformInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Edith Facade
 * @package Gentle\Edith\Facades
 * @const string $version
 * @method static ClassLoader classLoader()                Composer 加载器
 * @method static EdithPlatformInterface platform()        Edith Platform
 * @method static string routerPrefix()                    Edith Router prefix
 * @method static void routes()
 */
class Edith extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gentle\Edith\Application::class;
    }
}
