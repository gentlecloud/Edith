<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Antd Menu
 * @link https://ant.design/components/menu-cn
 * @method $this defaultOpenKeys(array $value)                              初始展开的 SubMenu 菜单项 key 数组
 * @method $this defaultSelectedKeys(array $value)                          初始选中的菜单项 key 数组
 * @method $this expandIcon(string $value)                                  自定义展开图标
 * @method $this inlineIndent(int $value)                                   inline 模式的菜单缩进宽度
 * @method $this mode(string $value)                                        菜单类型，现在支持垂直、水平、和内嵌模式三种	vertical | horizontal | inline
 * @method $this openKeys(array $value)                                     当前展开的 SubMenu 菜单项 key 数组
 * @method $this overflowedIndicator(string $value)                         用于自定义 Menu 水平空间不足时的省略收缩的图标
 * @method $this selectedKeys(array $value)                                 当前选中的菜单项 key 数组
 * @method $this subMenuCloseDelay(float $value)                            用户鼠标离开子菜单后关闭延时，单位：秒
 * @method $this subMenuOpenDelay(float $value)                             用户鼠标进入子菜单后开启延时，单位：秒
 * @method $this theme(string $value)                                       主题颜色	light | dark
 * @method $this triggerSubMenuAction(string $value)                        SubMenu 展开/关闭的触发行为	hover | click
 */
class Menu extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'menu';

    /**
     * 菜单内容
     * @var Collection
     */
    protected Collection $items;

    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * 在子菜单展示之前就渲染进 DOM
     * @param bool $value
     * @return self
     */
    public function forceSubMenuRender(bool $value = true): self
    {
        return $this->set('forceSubMenuRender', $value);
    }

    /**
     * inline 时菜单是否收起状态
     * @param bool $value
     * @return self
     */
    public function inlineCollapsed(bool $value = true): self
    {
        return $this->set('inlineCollapsed', $value);
    }

    /**
     * 是否允许多选
     * @param bool $value
     * @return self
     */
    public function multiple(bool $value = true): self
    {
        return $this->set('multiple', $value);
    }

    /**
     * 是否允许选中
     * @param bool $value
     * @return self
     */
    public function selectable(bool $value = true): self
    {
        return $this->set('selectable', $value);
    }

    /**
     * @param string $label
     * @param string|null $key
     * @return MenuItem
     */
    public function item(string $label, ?string $key = null): MenuItem
    {
        $column = new MenuItem($label, $key);

        return tap($column, function ($value) {
            $this->items->push($value);
        });
    }

    /**
     * @param array $items
     * @return $this
     */
    public function items(array $items): self
    {
        $this->items = new Collection($items);
        return $this;
    }

    /**
     * @param array $body
     * @return $this
     */
    public function body(array $body): self
    {
        $this->items = new Collection($body);
        return $this;
    }
}