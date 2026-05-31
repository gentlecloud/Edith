<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Empty
 * @link https://ant.design/components/empty-cn
 * @method $this description(string $value)                             自定义描述内容
 * @method $this image(string $value)                                   设置显示图片，为 string 时表示自定义图片地址。
 * @method $this imageStyle(array $value)                               图片样式
 */
class EmptyPage extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'empty';
}