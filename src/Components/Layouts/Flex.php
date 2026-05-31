<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Flex
 * @link https://ant.design/components/flex-cn
 * @method $this wrap(string|bool $wrap)                  设置元素单行显示还是多行显示	flex-wrap | boolean
 * @method $this justify(string $justify)                 设置元素在主轴方向上的对齐方式	justify-content
 * @method $this align(string $align)                     设置元素单行显示还是多行显示	flex-wrap | boolean
 * @method $this flex(string $flex)                       flex CSS 简写属性
 * @method $this gap(string|int $gap)                     设置网格之间的间隙    small | middle | large | string | number
 * @method $this component(string $div)                   自定义元素类型 div
 */
class Flex extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'flex';

    /**
     * flex 主轴的方向是否垂直，使用 flex-direction: column
     * @param bool $value
     * @return self
     */
    public function vertical(bool $value = true): self
    {
        return $this->set('vertical', $value);
    }
}