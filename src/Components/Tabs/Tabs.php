<?php
namespace Gentle\Edith\Components\Tabs;

use Gentle\Edith\Components\Renderer;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Ant Tab
 * 参考文档：https://ant.design/components/tabs-cn#Tabs.TabPane
 * @method $this activeKey(string $activeKey)                              当前激活 tab 面板的 key
 * @method $this defaultActiveKey(string $defaultActiveKey)                初始化选中面板的 key，如果没有设置 activeKey
 * @method $this addIcon($addIcon)                                         自定义添加按钮
 * @method $this moreIcon($moreIcon)                                       自定义折叠 icon
 * @method $this animated($animated)                                       是否使用动画切换 Tabs, 仅生效于 tabPosition="top",  boolean| { inkBar: boolean, tabPane: boolean }
 * @method $this popupClassName(string $popupClassName)                    更多菜单的 className
 * @method $this tabBarGutter(int $tabBarGutter)                           tabs 之间的间隙
 * @method $this tabBarStyle(array $tabBarStyle)                           tab bar 的样式对象
 * @method $this tabBarExtraContent($tabBarExtraContent)                   tab bar 上额外的元素
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Tabs extends Renderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'edith';

    /**
     * Edith 渲染类型
     * @var string
     */
    protected string $component = 'tabs';

    /**
     * @var Collection
     */
    protected Collection $items;

    /**
     * construct Tabs
     */
    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * 标签居中展示
     * @default false
     * @param bool $centered
     * @return Tabs
     */
    public function centered(bool $centered = true): Tabs
    {
        return $this->set('centered', $centered);
    }

    /**
     * 是否隐藏加号图标，在 type="editable-card" 时有效
     * @default false
     * @param bool $hideAdd
     * @return Tabs
     */
    public function hideAdd(bool $hideAdd = true): Tabs
    {
        return $this->set('hideAdd', $hideAdd);
    }

    /**
     * 大小
     * @default middle
     * @param string $size  large | middle | small
     * @return Tabs
     * @throws RendererException
     */
    public function size(string $size): Tabs
    {
        if (!in_array($size, ['large', 'middle', 'small'])) {
            throw new RendererException("Tabs size only supports large, middle or small");
        }
        return $this->set('size', $size);
    }

    /**
     * 页签位置
     * @default top
     * @param string $tabPosition top right bottom left
     * @return Tabs
     * @throws RendererException
     */
    public function tabPosition(string $tabPosition): Tabs
    {
        if (!in_array($tabPosition, ['top', 'right', 'bottom', 'left'])) {
            throw new RendererException("Tabs position only supports top, right, bottom, left");
        }
        return $this->set('tabPosition', $tabPosition);
    }

    /**
     * 被隐藏时是否销毁 DOM 结构
     * @default false
     * @param bool $destroyInactiveTabPane
     * @return Tabs
     */
    public function destroyInactiveTabPane(bool $destroyInactiveTabPane = true): Tabs
    {
        return $this->set('destroyInactiveTabPane', $destroyInactiveTabPane);
    }

    /**
     * 页签的基本样式
     * @default line
     * @param string $type line | card | editable-card
     * @return Tabs
     * @throws RendererException
     */
    public function type(string $type): Tabs
    {
        if (!in_array($type, ['line', 'card', 'editable-card'])) {
            throw new RendererException("Tabs type only supports line、card or editable-card");
        }
        return $this->set('type', $type);
    }

    /**
     * 子标签
     * @param string|null $label 选项卡头显示文字
     * @param string|null $key 对应 activeKey
     * @return TabPane
     */
    public function item(?string $label = null, ?string $key = null): TabPane
    {
        return tap(new TabPane($label, $key), function ($value) {
            $this->items->push($value);
        });
    }

    /**
     * @param string|null $label
     * @param \Closure $callback
     * @return $this
     */
    public function tab(?string $label, \Closure $callback): Tabs
    {
        $callback($pane = new TabPane($label));
        $this->items->push($pane);
        return $this;
    }

    /**
     * 批量添加子标签页
     * @param array|Collection $items
     * @return Tabs
     */
    public function items($items)
    {
        if (!($items instanceof Collection)) {
            $items = new Collection($items);
        }
        return $this->set('items', $items);
    }
}