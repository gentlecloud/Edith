<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd 炫富按钮
 * @link https://ant.design/components/float-button-cn
 * @method $this trigger(string $value)                         触发方式（有触发方式为菜单模式）	click | hover
 * @method $this closeIcon(string $value)                       自定义关闭按钮
 * @method $this placement(string $value)                         气泡卡片的内容
 * @method $this shape(string $value)                           设置包含的 FloatButton 按钮形状
 */
class FloatButtonGroup extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'float-button-group';

    /**
     * 受控展开，需配合 trigger 一起使用
     * @param bool $value
     * @return self
     */
    public function open(bool $value = true): self
    {
        return $this->set('open', $value);
    }
}