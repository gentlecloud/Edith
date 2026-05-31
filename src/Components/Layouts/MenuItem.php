<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Antd MenuItemType
 * @method $this extra(string $value)                                   额外节点
 * @method $this icon(string $value)                                    菜单图标
 * @method $this key(string $value)                                     item 的唯一标志
 * @method $this label(string $value)                                   菜单项标题
 * @method $this title(string $value)                                   设置收缩时展示的悬浮标题
 * @method $this popupClassName(string $value)                          子菜单样式，mode="inline" 时无效
 * @method $this popupOffset(array $value)                              子菜单偏移量，mode="inline" 时无效   [number, number]
 * @method $this theme(string $value)                                   设置子菜单的主题，默认从 Menu 上继承	light | dark
 */
class MenuItem extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'menu-item';

    /**
     *
     */
    public function __construct(?string $label = null, ?string $key = null)
    {
        parent::__construct();
        !is_null($label) && $this->set('label', $label);
        if (is_null($key)) {
            $this->key(uniqid('menu_item'));
        } else {
            $this->set('key', $key);
        }
    }

    /**
     * 展示错误状态样式
     * @param bool $value
     * @return self
     */
    public function danger(bool $value = true): self
    {
        return $this->set('danger', $value);
    }

    /**
     * 是否禁用
     * @param bool $value
     * @return self
     */
    public function disabled(bool $value = true): self
    {
        return $this->set('disabled', $value);
    }

    /**
     * @param array $children
     * @return self
     */
    public function children(array $children = []): self
    {
        return $this->set('children', new Collection($children));
    }
}