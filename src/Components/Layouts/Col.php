<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Grid
 * @link https://ant.design/components/grid-cn
 * @method $this flex(string|int $flex)                             flex 布局属性
 * @method $this offset(int $offset)                                栅格左侧的间隔格数，间隔内不可以有栅格
 * @method $this order(int $order)                                  栅格顺序
 * @method $this pull(int $pull)                                    栅格向左移动格数
 * @method $this push(int $push)                                    栅格向右移动格数
 * @method $this span(int $span)                                    栅格占位格数，为 0 时相当于 display: none
 * @method $this xs(int|array $value)                               窗口宽度 < 576px 响应式栅格，可为栅格数或一个包含其他属性的对象
 * @method $this sm(int|array $value)                               窗口宽度 < 576px 响应式栅格，可为栅格数或一个包含其他属性的对象
 * @method $this md(int|array $value)                               窗口宽度 ≥ 768px 响应式栅格，可为栅格数或一个包含其他属性的对象
 * @method $this lg(int|array $value)                               窗口宽度 ≥ 992px 响应式栅格，可为栅格数或一个包含其他属性的对象
 * @method $this xl(int|array $value)                               窗口宽度 ≥ 1200px 响应式栅格，可为栅格数或一个包含其他属性的对象
 * @method $this xxl(int|array $value)                              窗口宽度 ≥ 1600px 响应式栅格，可为栅格数或一个包含其他属性的对象
 */
class Col extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'col';
}