<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form InputTag 标签选择
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-tag
 * @method $this options(array $options)                        选项组
 * @method $this optionsTip(string $optionsTip)                 选项提示 默认： "最近您使用的标签"
 * @method $this source($source)                                动态选项组 string | API
 * @method $this delimiter(string $delimiter)                   拼接符
 * @method $this labelField(string $labelField)                 选项标签字段 默认： "label"
 * @method $this valueField(string $valueField)                 选项值字段 默认： "value"
 * @method $this resetValue(string $resetValue)                 删除后设置此配置项给定的值。
 * @method $this max(int $max)                                  允许添加的标签的最大数量
 * @method $this maxTagLength(int $maxTagLength)                单个标签的最大文本长度
 * @method $this maxTagCount(int $maxTagCount)                  标签的最大展示数量，超出数量后以收纳浮层的方式展示，仅在多选模式开启后生效
 * @method $this overflowTagPopover(array $overflowTagPopover)  收纳浮层的配置属性，详细配置参考Tooltip {"placement": "top", "trigger": "hover", "showArrow": false, "offset": [0, -10]}
 * @method $this separator(string $separator)                   开启批量添加后，输入多个标签的分隔符，支持传入多个符号，默认为"-"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputTag extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-tag';

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return InputTag
     */
    public function joinValues(bool $joinValues = true): InputTag
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return InputTag
     */
    public function extractValue(bool $extractValue = true): InputTag
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 在有值的时候是否显示一个删除图标在右侧。
     * @default false
     * @param bool $clearable
     * @return InputTag
     */
    public function clearable(bool $clearable = true): InputTag
    {
        return $this->set('clearable', $clearable);
    }

    /**
     * 是否开启批量添加模式
     * @default false
     * @param bool $enableBatchAdd
     * @return InputTag
     */
    public function enableBatchAdd(bool $enableBatchAdd = true): InputTag
    {
        return $this->set('enableBatchAdd', $enableBatchAdd);
    }
}