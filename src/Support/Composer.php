<?php
namespace Edith\Admin\Support;

use Composer\Autoload\ClassLoader;

class Composer
{
    /**
     * @var ClassLoader
     */
    protected static $loader;

    /**
     * 获取 composer 类加载器.
     * @return ClassLoader
     */
    public static function loader()
    {
        if (! static::$loader) {
            static::$loader = include base_path().'/vendor/autoload.php';
        }

        return static::$loader;
    }
}