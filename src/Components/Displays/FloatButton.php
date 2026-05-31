<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd 悬浮按钮
 * @link https://ant.design/components/float-button-cn
 * @method $this icon(string $value)                            自定义图标
 * @method $this description(string $value)                     文字及其它内容
 * @method $this tooltip(string $value)                         气泡卡片的内容
 * @method $this type(string $value)                            设置按钮类型	default | primary
 * @method $this shape(string $value)                           设置按钮形状	circle | square
 * @method $this href(string $value)                            点击跳转的地址，指定此属性 button 的行为和 a 链接一致
 * @method $this target(string $value)                          相当于 a 标签的 target 属性，href 存在时生效
 * @method $this htmlType(string $value)                        设置 button 原生的 type 值，可选值请参考 HTML 标准	submit | reset | button
 * @method $this badge(string $value)                           带徽标数字的悬浮按钮（不支持 status 以及相关属性）
 */
class FloatButton extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'float-button';
}