<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form ListSelect 列表
 * ListSelect 一般用来实现选择，可以单选也可以多选，和 Radio/Checkboxs 最大的不同是在展现方面支持带图片。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/list-select
 * @method $this options(array $options)                       选项组
 * @method $this source($source)                               动态选项组 string | API
 * @method $this labelField(string $labelField)                选项标签字段 默认： "label"
 * @method $this valueField(string $valueField)                选项值字段 默认： "value"
 * @method $this listClassName(string $listClassName)          支持配置 list div 的 css 类名。比如: flex justify-between
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class ListSelect extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'list-select';

    /**
     * 多选
     * @default false
     * @param bool $multiple
     * @return ListSelect
     */
    public function multiple(bool $multiple = true): ListSelect
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return ListSelect
     */
    public function joinValues(bool $joinValues = true): ListSelect
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @param bool $extractValue
     * @return ListSelect
     */
    public function extractValue(bool $extractValue = true): ListSelect
    {
        return $this->set('extractValue', $extractValue);
    }
}