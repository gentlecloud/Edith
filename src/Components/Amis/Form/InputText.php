<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis InputText
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-text
 * @method $this options(array $options)                                  选项组
 * @method $this source($source)                                          动态选项组 string | API
 * @method $this autoComplete($autoComplete)                              自动补全 string | API
 * @method $this delimiter(string $delimiter)                             拼接符 默认： ","
 * @method $this labelField(string $labelField)                           选项标签字段 默认： "label"
 * @method $this valueField(string $valueField)                           选项值字段 默认： "value"
 * @method $this addOn($addOn)                                            输入框附加组件，比如附带一个提示文字，或者附带一个提交按钮。
 * @method $this resetValue(string $resetValue)                           清除后设置此配置项给定的值。
 * @method $this prefix(string $prefix)                                   前缀
 * @method $this suffix(string $suffix)                                   后缀
 * @method $this minLength(int $minLength)                                限制最小字数
 * @method $this maxLength(int $maxLength)                                限制最大字数
 * @method $this transform(array $transform)                              自动转换值，可选 transform: { lowerCase: true, upperCase: true }
 * @method $this borderMode(string $borderMode)                           输入框边框模式，全边框，还是半边框，或者没边框。 默认： full 可选：full | half | none
 * @method $this inputControlClassName(string $inputControlClassName)     control 节点的 CSS 类名
 * @method $this nativeInputClassName(string $nativeInputClassName)       原生 input 标签的 CSS 类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputText extends FormItem
{
    /**
     * Amis Form 渲染类型
     * @var string
     */
    protected string $type = 'input-text';

    /**
     * 是否多选
     * @param bool $multiple
     * @return InputText
     */
    public function multiple(bool $multiple = true): InputText
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return InputText
     */
    public function joinValues(bool $joinValues = false): InputText
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return InputText
     */
    public function extractValue(bool $extractValue = true): InputText
    {
        return $this->set('extractValue', $extractValue);
    }

    /***
     * 是否去除首尾空白文本。
     * @param bool $trimContents
     * @return InputText
     */
    public function trimContents(bool $trimContents = true): InputText
    {
        return $this->set('trimContents', $trimContents);
    }

    /**
     * 文本内容为空时去掉这个值
     * @param bool $clearValueOnEmpty
     * @return InputText
     */
    public function clearValueOnEmpty(bool $clearValueOnEmpty = true): InputText
    {
        return $this->set('clearValueOnEmpty', $clearValueOnEmpty);
    }

    /***
     * 是否可以创建，默认为可以，除非设置为 false 即只能选择选项中的值
     * @param bool $creatable
     * @return InputText
     */
    public function creatable(bool $creatable= true): InputText
    {
        return $this->set('creatable', $creatable);
    }

    /**
     * 是否可清除
     * @param bool $clearable
     * @return InputText
     */
    public function clearable(bool $clearable = true): InputText
    {
        return $this->set('clearable', $clearable);
    }

    /**
     * 是否显示计数器
     * @param bool $showCounter
     * @return InputText
     */
    public function showCounter(bool $showCounter = true): InputText
    {
        return $this->set('showCounter', $showCounter);
    }
}