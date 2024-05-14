<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\Renderer;
use Illuminate\Support\Collection;

/**
 * Ant Tabs 标签
 * 使用 ProCard 卡片展现
 * @method Tabs activeKey(string $activeKey)                       当前选中项
 * @method Tabs addIcon($icon)                                     自定义添加按钮
 * @method Tabs animated($animated)                                是否使用动画切换 Tabs, 仅生效于 tabPosition="top", boolean | { inkBar: boolean, tabPane: boolean }
 * @method Tabs defaultActiveKey(string $defaultActiveKey)         初始化选中面板的 key，如果没有设置 activeKey
 * @method Tabs hideAdd(bool $hideAdd = true)                      是否隐藏加号图标，在 type="editable-card" 时有效
 * @method Tabs moreIcon($icon)                                    自定义折叠 icon
 * @method Tabs popupClassName(string $popupClassName)             更多菜单的 className
 * @method Tabs tabBarExtraContent($tabBarExtraContent)            tab bar 上额外的元素
 * @method Tabs tabBarGutter(int $tabBarGutter)                    tabs 之间的间隙
 * @method Tabs tabBarStyle($tabBarStyle)                          tab bar 的样式对象
 * @method Tabs destroyInactiveTabPane(bool $destroy)              被隐藏时是否销毁 DOM 结构
 * @author Chico Written in Xiamen on 2022.11.30, Xiamen Gentle Technology Co., Ltd
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Tabs extends Renderer
{
    /**
     * Edith component
     * @var string
     */
    protected string $renderer = 'tabs';

    /**
     * 标签居中展示
     * @var bool
     */
    protected bool $centered = false;

    /**
     * Ant proCardTabs 页签的基本样式
     * @var string line、card、editable-card
     */
    protected string $type = 'line';

    /**
     * 页签位置，可选值有 top | right | bottom | left
     * @var string
     * @default top
     */
    protected string $tabPosition = 'top';


    /**
     * 选项卡
     * @var Collection|null
     */
    protected ?Collection $items;

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
     * @param bool $mode true | false
     * @default false
     * @return $this
     */
    public function centered(bool $mode = true): Tabs
    {
        $this->centered = $mode;
        return $this;
    }

    /**
     * Ant proCardTabs 页签的基本样式
     * @param string $type line | card | editable-card
     * @return $this
     * @throws \Exception
     */
    public function type(string $type): Tabs
    {
        if (!in_array($type, ['line', 'card', 'editable-card'])) {
            throw new \Exception("Tabs only supports setting 'line', 'card', 'editable card'");
        }
        $this->type = $type;
        return $this;
    }

    /**
     * 页签位置
     * @param string $position top | right | bottom | left
     * @return $this
     * @throws \Exception
     */
    public function tabPosition(string $position): Tabs
    {
        if (!in_array($position, ['top', 'right', 'bottom', 'left'])) {
            throw new \Exception("Position only supports setting 'top', 'right', 'bottom', 'left'");
        }
        $this->tabPosition = $position;
        return $this;
    }

    /**
     * 基于 antd 拓展的页签的基本配置，必填 [{label: '标签一', key: 'tab1', children: '内容一'}]
     * @param array|Collection $items
     * @return $this
     */
    public function items($items): Tabs
    {
        if ($items instanceof Collection) {
            $this->items = $items;
        } else {
            $this->items = new Collection($items);
        }
        return $this;
    }

    /**
     * 添加选项卡
     * @param string|null $key 对应标签 activeKey
     * @param string|null $label 选项卡头显示文字
     * @return TabPane
     */
    public function tab(?string $key = null, ?string $label = null): TabPane
    {
        return tap(new TabPane($key, $label), function ($value) {
            $this->items->push($value);
        });
    }
}