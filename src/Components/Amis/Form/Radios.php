<?php
namespace Gentle\Edith\Components\Amis\Form;

/***
 * Amis Form Radios 单选框
 * @api
 * @method $this options(array $options)                   选项组
 * @method $this source($source)                           动态选项组 string | API
 * @method $this labelField(string $labelField)            选项标签字段 默认： 'label'
 * @method $this valueField(string $valueField)            选项值字段 默认： 'value'
 * @method $this columnsCount(int $columnsCount)           选项按几列显示，默认为一列 默认: 1
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Radios extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'radios';

    /**
     * 是否显示为一行
     * @default true
     * @param bool $inline
     * @return Radios
     */
    public function inline(bool $inline = true): Radios
    {
        return $this->set('inline', $inline);
    }

    /**
     * 是否默认选中第一个
     * @param bool $selectFirst
     * @return Radios
     */
    public function selectFirst(bool $selectFirst = true): Radios
    {
        return $this->set('selectFirst', $selectFirst);
    }
}