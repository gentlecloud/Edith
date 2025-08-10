<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Pro WaterMark
 * @link https://procomponents.ant.design/components/water-mark
 * @method $this width(int $value)                              水印的宽度 默认 120
 * @method $this height(int $value)                             水印的高度 默认 64
 * @method $this rotate(int $value)                             水印绘制时，旋转的角度，单位  默认 -22
 * @method $this image(string $value)                           图片源，建议导出 2 倍或 3 倍图，优先使用图片渲染水印
 * @method $this zIndex(int $value)                             追加的水印元素的 z-index
 * @method $this content(string|array $value)                   水印文字内容
 * @method $this fontColor(string $value)                       水印文字颜色
 * @method $this fontSize(int $value)                           文字大小
 * @method $this markStyle(array $value)                        水印层的样式
 * @method $this markClassName(string $value)                   水印层的类名
 * @method $this gapX(int $value)                               水印之间的水平间距
 * @method $this gapY(int $value)                               水印层的样式
 * @method $this offsetLeft(int $value)                         水印在 canvas 画布上绘制的水平偏移量，正常情况下，水印绘制在中间位置，即 offsetLeft = gapX / 2
 * @method $this offsetTop(int $value)                          水印在 canvas 画布上绘制的垂直偏移量，正常情况下，水印绘制在中间位置，即 offsetTop = gapY / 2
 */
class WaterMark extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'water-mark';

    public function __construct(?string $content = null)
    {
        parent::__construct();
        !is_null($content) && $this->set('content', $content);
    }
}