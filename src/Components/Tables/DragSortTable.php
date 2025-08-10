<?php
namespace Edith\Admin\Components\Tables;

/**
 * Antd DragSortTable
 * @link https://procomponents.ant.design/components/drag-sort-table
 * @method $this dragSortKey(string $value)                     如配置此参数，则会在该 key 对应的行显示拖拽排序把手，允许拖拽排序
 */
class DragSortTable extends Table
{
    /**
     * @var string
     */
    protected string $renderer = 'drag-sort-table';

    /**
     * 如配置此参数，则会在该 key 对应的行显示拖拽排序把手，允许拖拽排序
     * @var string 
     */
    protected string $dragSortKey = 'sort';
}