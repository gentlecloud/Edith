<?php
namespace Gentle\Edith\Components\Amis;

use Illuminate\Support\Collection;

/**
 * Amis Tabs 选项卡
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/tabs
 * @method $this defaultKey($defaultKey)                                  组件初始化时激活的选项卡，hash 值或索引值，支持使用表达式
 * @method $this activeKey($activeKey)                                    激活的选项卡，hash 值或索引值，支持使用表达式，可响应上下文数据变化
 * @method $this tabsClassName(string $tabsClassName)                     Tabs Dom 的类名
 * @method $this source(string $source)                                   tabs 关联数据，关联后可以重复生成选项卡
 * @method $this toolbar(array $toolbar)                                  tabs 中的工具栏
 * @method $this toolbarClassName(string $toolbarClassName)               tabs 中工具栏的类名
 * @method $this addBtnText(string $addBtnText)                           新增按钮文案
 * @method $this showTipClassName(string $showTipClassName)               提示的类
 * @method $this sidePosition(string $sidePosition)                       sidebar 模式下，标签栏位置   left | right
 * @method $this collapseOnExceed(int $collapseOnExceed)                  当 tabs 超出多少个时开始折叠
 * @method $this collapseBtnLabel(string $collapseBtnLabel)               用来设置折叠按钮的文字 默认： more
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Tabs extends AmisRenderer
{
    /**
     * Amis 组件渲染类型
     * @var string
     */
    protected string $type = 'tabs';

    /**
     * 展示模式
     * @var string line、card、radio、vertical、chrome、simple、strong、tiled、sidebar
     */
    protected string $tabsMode = "line";

    /**
     * @var array|Collection
     */
    protected $tabs;

    /**
     * construct Tabs
     */
    public function __construct()
    {
        parent::__construct();
        $this->tabs = new Collection();
    }

    /**
     * 展示模式
     * @param string $tabsMode line|card|radio|vertical
     * @return $this
     * @throws \Exception
     */
    public function tabsMode(string $tabsMode): Tabs
    {
        if (!in_array($tabsMode, ['line','card','radio','vertical','chrome','simple','strong','tiled','sidebar'])) {
            throw new \Exception('Tabs mode only supports line、card、radio、vertical、chrome、simple、strong、tiled、sidebar');
        }
        return $this->set('tabsMode', $tabsMode);
    }

    /**
     * 只有在点中 tab 的时候才渲染
     * @default false
     * @param bool $mountOnEnter
     * @return Tabs
     */
    public function mountOnEnter(bool $mountOnEnter = true): Tabs
    {
        return $this->set('mountOnEnter', $mountOnEnter);
    }

    /**
     * 切换 tab 的时候销毁
     * @default false
     * @param bool $unmountOnExit
     * @return Tabs
     */
    public function unmountOnExit(bool $unmountOnExit = true): Tabs
    {
        return $this->set('unmountOnExit', $unmountOnExit);
    }

    /**
     * 是否支持新增
     * @default false
     * @param bool $addable
     * @return Tabs
     */
    public function addable(bool $addable = true): Tabs
    {
        return $this->set('addable', $addable);
    }

    /**
     * 是否支持删除
     * @default false
     * @param bool $closable
     * @return Tabs
     */
    public function closable(bool $closable = true): Tabs
    {
        return $this->set('closable', $closable);
    }

    /**
     * 是否支持拖拽
     * @default false
     * @param bool $draggable
     * @return Tabs
     */
    public function draggable(bool $draggable = true): Tabs
    {
        return $this->set('draggable', $draggable);
    }

    /**
     * 是否支持提示
     * @default false
     * @param bool $showTip
     * @return Tabs
     */
    public function showTip(bool $showTip = true): Tabs
    {
        return $this->set('showTip', $showTip);
    }

    /**
     * 收否可编辑标签名
     * @default false
     * @param bool $editable
     * @return Tabs
     */
    public function editable(bool $editable = true): Tabs
    {
        return $this->set('editable', $editable);
    }

    /**
     * tabs 内容
     * @param array|Collection $tabs
     * @return Tabs
     */
    public function tabs($tabs): Tabs
    {
        if (!($tabs instanceof Collection)) {
            $tabs = new Collection($tabs);
        }
        return $this->set('tabs', $tabs);
    }

    /**
     * 添加标签
     * @param string $title
     * @param string|array|object $tab
     * @return Tabs
     */
    public function item(string $title, $tab): Tabs
    {
        $this->tabs->push(new Collection(['title' => $title, 'tab' => $tab]));
        return $this;
    }
}
