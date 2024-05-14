<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form NestedSelect 级联选择
 * @api
 * @method $this options(array $options)                         	选项组
 * @method $this source($source)                         	        动态选项组
 * @method $this delimiter(string $delimiter)                       拼接符
 * @method $this labelField(string $labelField)                     选项标签字段 默认： 'label'
 * @method $this valueField(string $valueField)                     选项值字段 默认： 'value'
 * @method $this searchPromptText(string $searchPromptText)         搜索框占位文本 默认： "输入内容进行检索"
 * @method $this noResultsText(string $noResultsText)               无结果时的文本 默认："未找到任何结果"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class NestedSelect extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'nested-select';

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return NestedSelect
     */
    public function joinValues(bool $joinValues = true): NestedSelect
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return NestedSelect
     */
    public function extractValue(bool $extractValue = true): NestedSelect
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 设置 true时，当选中父节点时不自动选择子节点。
     * @default false
     * @param bool $cascade
     * @return NestedSelect
     */
    public function cascade(bool $cascade = true): NestedSelect
    {
        return $this->set('cascade', $cascade);
    }

    /**
     * 设置 true时，选中父节点时，值里面将包含子节点的值，否则只会保留父节点的值。
     * @default false
     * @param bool $withChildren
     * @return NestedSelect
     */
    public function withChildren(bool $withChildren = true): NestedSelect
    {
        return $this->set('withChildren', $withChildren);
    }

    /**
     * 多选时，选中父节点时，是否只将其子节点加入到值中。
     * @default false
     * @param bool $onlyChildren
     * @return NestedSelect
     */
    public function onlyChildren(bool $onlyChildren = true): NestedSelect
    {
        return $this->set('onlyChildren', $onlyChildren);
    }

    /**
     * 可否搜索
     * @default false
     * @param bool $searchable
     * @return NestedSelect
     */
    public function searchable(bool $searchable = true): NestedSelect
    {
        return $this->set('searchable', $searchable);
    }

    /**
     * 可否多选
     * @default false
     * @param bool $multiple
     * @return NestedSelect
     */
    public function multiple(bool $multiple = true): NestedSelect
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 是否隐藏选择框中已选择节点的路径 label 信息
     * @default false
     * @param bool $hideNodePathLabel
     * @return NestedSelect
     */
    public function hideNodePathLabel(bool $hideNodePathLabel = true): NestedSelect
    {
        return $this->set('hideNodePathLabel', $hideNodePathLabel);
    }

    /**
     * 只允许选择叶子节点
     * @default false
     * @param bool $onlyLeaf
     * @return NestedSelect
     */
    public function onlyLeaf(bool $onlyLeaf = true): NestedSelect
    {
        return $this->set('onlyLeaf', $onlyLeaf);
    }
}