<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Color 颜色
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/color
 * @method $this value(string $value)                        显示的颜色值
 * @method $this name(string $name)                          在其他组件中，时，用作变量映射
 * @method $this defaultColor(string $defaultColor)          默认颜色值 默认： #ccc
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Color extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'color';

    /**
     * 是否显示右边的颜色值
     * @default true
     * @param bool $showValue
     * @return Color
     */
    public function showValue(bool $showValue = true): Color
    {
        return $this->set('showValue', $showValue);
    }
}