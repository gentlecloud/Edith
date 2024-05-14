<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form MatrixCheckboxes 矩阵
 * 矩阵类型的输入框。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/matrix-checkboxes
 * @method $this columns(array $columns)                    列信息，数组中 label 字段是必须给出的
 * @method $this rows(array $rows)                          行信息， 数组中 label 字段是必须给出的
 * @method $this rowLabel(string $rowLabel)                 行标题说明
 * @method $this source($source)                            Api 地址，如果选项组不固定，可以通过配置 source 动态拉取。 string | API
 * @method $this singleSelectMode(string $singleSelectMode) 设置单选模式，multiple为false时有效，可设置为cell, row, column 分别为全部选项中只能单选某个单元格、每行只能单选某个单元格，每列只能单选某个单元格 默认： 'column'
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class MatrixCheckboxes extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'matrix-checkboxes';

    /**
     * 是否多选
     * @default true
     * @param bool $multiple
     * @return MatrixCheckboxes
     */
    public function multiple(bool $multiple = true): MatrixCheckboxes
    {
        return $this->set('multiple', $multiple);
    }
}