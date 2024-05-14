<?php
namespace Edith\Admin\Components\Amis\Table;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis TableView 表格视图
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/table-view
 * @method $this width($width)                    表格宽 默认 100%
 * @method $this padding($padding)                单元格默认内间距 默认： 'var(--TableCell-paddingY) var(--TableCell-paddingX)'
 * @method $this borderColor(string $borderColor) 边框颜色 默认： var(--borderColor)
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class TableView extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'table-view';

    /**
     * 是否显示边框
     * @default true
     * @param bool $border
     * @return TableView
     */
    public function border(bool $border = true): TableView
    {
        return $this->set('border', $border);
    }

    /**
     * @param $trs
     * @return TableView
     */
    public function trs($trs): TableView
    {
        return $this->set('trs', $trs);
    }

    /**
     * @param $tds
     * @return TableView
     */
    public function tds($tds): TableView
    {
        return $this->set('tds', $tds);
    }
}