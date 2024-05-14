<?php
namespace Edith\Admin\Components\Amis;

use Edith\Admin\Components\Amis\Table\Column;
use Illuminate\Support\Collection;

/**
 * Amis Table 表格
 * 表格展示，不支持配置初始化接口初始化数据域，所以需要搭配类似像Service这样的，具有配置接口初始化数据域功能的组件，或者手动进行数据域初始化，然后通过source属性，获取数据链中的数据，完成数据展示。
 * 文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/table
 * @method $this title(string $title)                                    标题
 * @method $this source(string $source)                                  数据源, 绑定当前环境变量
 * @method $this columnsTogglable($columnsTogglable)                     展示列显示开关, 自动即：列数量大于或等于 5 个时自动开启. auto 或 bool
 * @method $this placeholder(string $placeholder)                        当没数据的时候的文字提示 默认： 暂无数据
 * @method $this tableClassName(string $tableClassName)                  表格 CSS 类名 默认： table-db table-striped
 * @method $this headerClassName(string $headerClassName)                顶部外层 CSS 类名
 * @method $this footerClassName(string $footerClassName)                底部外层 CSS 类名
 * @method $this toolbarClassName(string $toolbarClassName)              工具栏 CSS 类名
 * @method $this combineNum(int $combineNum)                             自动合并单元格
 * @method $this itemActions(array $itemActions)                         悬浮行操作按钮组
 * @method $this itemCheckableOn($itemCheckableOn)                       配置当前行是否可勾选的条件，要用 表达式
 * @method $this itemDraggableOn($itemDraggableOn)                       配置当前行是否可拖拽的条件，要用 表达式
 * @method $this rowClassName(string $rowClassName)                      给行添加 CSS 类名
 * @method $this rowClassNameExpr($rowClassNameExpr)                     通过模板给行添加 CSS 类名
 * @method $this prefixRow(array $prefixRow)                             顶部总结行
 * @method $this affixRow(array $affixRow)                               底部总结行
 * @method $this itemBadge($itemBadge)                                   行角标配置
 * @method $this autoFillHeight($autoFillHeight)                         内容区域自适应高度 , boolean 丨 {height: number}
 * @method $this footable($footable)                                     是否开启底部展示功能，适合移动端展示
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Table extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'table';

    /**
     * 列信息
     * @var Collection
     */
    protected Collection $columns;

    /**
     * construct table
     */
    public function __construct()
    {
        parent::__construct();
        $this->columns = new Collection();
    }

    /**
     * 是否固定表头
     * @default true
     * @param bool $affixHeader
     * @return Table
     */
    public function affixHeader(bool $affixHeader = true): Table
    {
        return $this->set('affixHeader', $affixHeader);
    }

    /**
     * 点击数据行是否可以勾选当前行
     * @default false
     * @param bool $checkOnItemClick
     * @return Table
     */
    public function checkOnItemClick(bool $checkOnItemClick = true): Table
    {
        return $this->set('checkOnItemClick', $checkOnItemClick);
    }

    /**
     * 列宽度是否支持调整
     * @default true
     * @param bool $resizable
     * @return Table
     */
    public function resizable(bool $resizable = true): Table
    {
        return $this->set('resizable', $resizable);
    }

    /**
     * 支持勾选
     * @default false
     * @param bool $selectable
     * @return Table
     */
    public function selectable(bool $selectable = true): Table
    {
        return $this->set('selectable', $selectable);
    }

    /**
     * 勾选 icon 是否为多选样式checkbox， 默认为radio
     * @param bool $multiple
     * @return Table
     */
    public function multiple(bool $multiple = true): Table
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 设置列信息
     * @param array|Collection $columns
     * @return Table
     */
    public function columns($columns): Table
    {
        if ($columns instanceof Collection) {
            $this->columns = $columns;
        } else {
            $this->columns = new Collection($columns);
        }
        return $this;
    }

    /**
     * 添加表格列
     * @param string|null $name 关联字段
     * @param string|null $label 表头
     * @return Column
     */
    public function column(?string $name = null, ?string $label = null): Column
    {
        return tap(new Column($name, $label), function ($value) {
            $this->columns->push($value);
        });
    }
}