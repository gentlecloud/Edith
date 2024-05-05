<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis GridNav 宫格导航
 * 宫格菜单导航，不支持配置初始化接口初始化数据域，所以需要搭配类似像Service、Form或CRUD这样的，具有配置接口初始化数据域功能的组件，或者手动进行数据域初始化，然后通过source属性，获取数据链中的数据，完成菜单展示。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/grid-nav
 * @method $this itemClassName(string $itemClassName)                        列表项 css 类名
 * @method $this value(array $value)                                         图片数组
 * @method $this source($source)                                             数据源  string | API
 * @method $this gutter(int $gutter)                                         列表项之间的间距，默认单位为px
 * @method $this iconRatio(int $iconRatio)                                   图标宽度占比，单位% 默认： 60
 * @method $this direction(string $direction)                                列表项内容排列的方向，可选值为 horizontal 、vertical 默认： vertical
 * @method $this columnNum(int $columnNum)                                   列数 默认： 4
 * @method $this options(array $options)                                     列表项
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class GridNav extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'grid-nav';

    /**
     * 是否将列表项固定为正方形
     * @param bool $square
     * @return GridNav
     */
    public function square(bool $square = true): GridNav
    {
        return $this->set('square', $square);
    }

    /**
     * 是否将列表项内容居中显示
     * @default true
     * @param bool $center
     * @return GridNav
     */
    public function center(bool $center = true): GridNav
    {
        return $this->set('center', $center);
    }

    /**
     * 是否显示列表项边框
     * @default true
     * @param bool $border
     * @return GridNav
     */
    public function border(bool $border = true): GridNav
    {
        return $this->set('border', $border);
    }

    /**
     * 是否调换图标和文本的位置
     * @param bool $reverse
     * @return GridNav
     */
    public function reverse(bool $reverse = true): GridNav
    {
        return $this->set('reverse', $reverse);
    }

    public function nav()
    {

    }
}