<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Divider
 * @link https://ant.design/components/divider-cn
 * @method $this variant(string $variant)                               分割线是虚线、点线还是实线	dashed | dotted | solid
 * @method $this orientation(string $orientation)                       分割线标题的位置	start | end | center
 * @method $this orientationMargin(string|int $title)                   标题和最近 left/right 边框之间的距离，去除了分割线，同时 orientation 不能为 center。如果传入 string 类型的数字且不带单位，默认单位是 px	string | number
 * @method $this size(string $size)                                     间距大小，仅对水平布局有效	small | middle | large
 * @method $this type(string $type)                                     水平还是垂直类型	horizontal | vertical
 */
class Divider extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'divider';

    /**
     * 是否虚线
     * @param bool $value
     * @return self
     */
    public function dashed(bool $value = true): self
    {
        return $this->set('dashed', $value);
    }

    /**
     * 文字是否显示为普通正文样式
     * @param bool $value
     * @return self
     */
    public function plain(bool $value = true): self
    {
        return $this->set('plain', $value);
    }

    /**
     * 嵌套的标题
     * @param string|array|object $children
     * @return self
     */
    public function children(string|array|object $children): self
    {
        return $this->set('body', $children);
    }
}