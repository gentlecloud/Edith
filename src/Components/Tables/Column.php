<?php
namespace Edith\Admin\Components\Tables;

use Edith\Admin\Components\Columns\Column as BaseColumn;
use Edith\Admin\Exceptions\RendererException;

/**
 * Antd Table Column 列
 * https://ant.design/components/table-cn#column
 * @method $this defaultFilteredValue(array $defaultFilteredValue)                  默认筛选值
 * @method $this defaultSortOrder(string $defaultSortOrder)                         默认排序顺序	ascend | descend
 * @method $this filteredValue(array $filteredValue)                                筛选的受控属性，外界可用此控制列的筛选状态，值为已筛选的 value 数组
 * @method $this filterIcon(string $filterIcon)                                     自定义 filter 图标。
 * @method $this filterMode(string $filterMode)                                     指定筛选菜单的用户界面  'menu' | 'tree'
 * @method $this rowScope(string $rowScope)                                         设置列范围
 * @method $this quickEditEnabledOn(string $quickEditEnabledOn)                     快速编辑启用条件
 * @method $this display($content)                                                  自定义渲染
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.ieda.cc
 */
class Column extends BaseColumn
{
    /**
     * @var bool
     */
    public bool $search = false;

    /**
     * 点击重置按钮的时候，是否恢复默认筛选值
     * @param bool $filterResetToDefaultFilteredValue false
     * @default false
     * @return $this
     */
    public function filterResetToDefaultFilteredValue(bool $filterResetToDefaultFilteredValue = true): self
    {
        return $this->set('filterResetToDefaultFilteredValue', $filterResetToDefaultFilteredValue);
    }

    /**
     * 标识数据是否经过过滤，筛选图标会高亮
     * @param bool $value false
     * @default false
     * @return $this
     */
    public function filtered(bool $value = true): self
    {
        return $this->set('filtered', $value);
    }

    /**
     * 是否在筛选菜单关闭时触发筛选
     * @param bool $value false
     * @default true
     * @return $this
     */
    public function filterOnClose(bool $value = false): self
    {
        return $this->set('filterOnClose', $value);
    }

    /**
     * 是否多选
     * @param bool $value false
     * @default true
     * @return $this
     */
    public function filterMultiple(bool $value = false): self
    {
        return $this->set('filterMultiple', $value);
    }

    /**
     * 筛选菜单项是否可搜索
     * @param bool $value false
     * @default false
     * @return $this
     */
    public function filterSearch(bool $value = false): self
    {
        return $this->set('filterSearch', $value);
    }

    /**
     * （IE 下无效）列是否固定，可选 true (等效于 'start') 'start' 'end'
     * @param bool|string $value
     * @return $this
     * @throws RendererException
     * @default false
     */
    public function fixed(bool|string $value = true): self
    {
        if (!is_bool($value) && !in_array($value, ['start', 'end'])) {
            throw new RendererException('Column fixed value must be either "start" or "end".');
        }
        return $this->set('fixed', $value);
    }

    /**
     * 在 Table Column 中隐藏
     * @param bool $hidden
     * @default false
     * @return $this
     */
    public function hidden(bool $hidden = true): static
    {
        return $this->set('hidden', $hidden);
    }

    /**
     * 在编辑表格中是否可编辑的，函数的参数和 table 的 render 一样
     * @param bool|array $editable false | (text: any, record: T,index: number) => boolean
     * @default true
     * @return $this
     */
    public function editable(bool|array $editable = true): self
    {
        return $this->set('editable', $editable);
    }

    /**
     * 列设置排序
     * @param bool $sorter boolean
     * @return $this
     */
    public function sorter(bool $sorter = true): self
    {
        return $this->set('sorter', $sorter);
    }

    /**
     * 开启搜索栏
     * @param bool $value boolean
     * @return $this
     */
    public function showInSearch(bool $value = true): self
    {
        return $this->set('search', $value);
    }

    /**
     * 开启搜索栏
     * @param bool $value boolean
     * @return $this
     */
    public function showOnlyInSearch(bool $value = false): self
    {
        $this->set('hideInTable', true);
        $this->set('hideInForm', true);
        $this->set('hideInDescriptions', true);
        return $this->set('search', $value);
    }
}