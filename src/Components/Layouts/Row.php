<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Grid
 * @link https://ant.design/components/grid-cn
 * @method $this align(string|array $align)                               垂直对齐方式	top | middle | bottom | stretch | {[key in 'xs' | 'sm' | 'md' | 'lg' | 'xl' | 'xxl']: 'top' | 'middle' | 'bottom' | 'stretch'}
 * @method $this gutter(int|array $gutter)                                栅格间隔，可以写成像素值或支持响应式的对象写法来设置水平间隔 { xs: 8, sm: 16, md: 24}。或者使用数组形式同时设置 [水平间距, 垂直间距]
 * @method $this justify(string|array $justify)                           水平排列方式	start | end | center | space-around | space-between | space-evenly | {[key in 'xs' | 'sm' | 'md' | 'lg' | 'xl' | 'xxl']: 'start' | 'end' | 'center' | 'space-around' | 'space-between' | 'space-evenly'}
 */
class Row extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'row';

    /**
     * 是否自动换行
     * @param bool $wrap
     * @return self
     */
    public function wrap(bool $wrap = true): self
    {
        return $this->set('wrap', $wrap);
    }
}