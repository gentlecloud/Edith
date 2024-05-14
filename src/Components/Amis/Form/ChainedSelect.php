<?php
namespace Edith\Admin\Components\Amis\Form;

/***
 * Amis Form Chained-Select 链式下拉框
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/chain-select
 * @method $this options(array $options)                            选项组
 * @method $this source($source)                                    动态选项组 string | API
 * @method $this autoComplete($autoComplete)                        自动选中 string | API
 * @method $this delimiter(string $delimiter)                       拼接符 默认： ","
 * @method $this labelField(string $labelField)                     选项标签字段 默认："label"
 * @method $this valueField(string $valueField)                     选项值字段 默认："value"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class ChainedSelect extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'chained-select';

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return ChainedSelect
     */
    public function joinValues(bool $joinValues = true): ChainedSelect
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return ChainedSelect
     */
    public function extractValue(bool $extractValue = true): ChainedSelect
    {
        return $this->set('extractValue', $extractValue);
    }
}