<?php
namespace Gentle\Edith\Components\Tables;

use Gentle\Edith\Components\Fields\Column as BasicColumn;

/**
 * Antd Table Column 表格列
 * @method $this colSize(int $colSize)                                 一个表单项占用的格子数量, 占比= colSize*span，colSize 默认为 1 ，span 为 8，span是form={{span:8}} 全局设置的
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn
 */
class Column extends BasicColumn
{
    /**
     * 表头的筛选菜单项，当值为 true 时，自动使用 valueEnum 生成
     * @param array|bool $filters
     * @return Column
     */
    public function filters($filters = true): Column
    {
        return $this->set('filters', $filters);
    }

    /**
     * 配置列的搜索相关，false 为隐藏
     * @param bool $search false | { transform: (value: any) => any }
     * @default true
     * @return Column
     */
    public function search(bool $search): Column
    {
        return $this->set('search', $search);
    }

    /**
     * 列设置中disabled的状态
     * @param bool|array $disable boolean | { checkbox: boolean; }
     * @return Column
     */
    public function disable($disable = true): Column
    {
        return $this->set('disable', $disable);
    }
}