<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Components\Amis\AmisRenderer;
use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis FormItem 普通表单项
 * 表单项 是组成一个表单的基本单位，它具有的一些特性会帮助我们更好地实现表单操作。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/formitem
 * @method $this inputClassName(string $inputClassName)                表单控制器类名
 * @method $this labelClassName(string $labelClassName)                label 的类名
 * @method $this name(string $name)                                    字段名，指定该表单项提交时的 key
 * @method $this value($value)                                         表单默认值
 * @method $this label($label)                                         表单项标签
 * @method $this labelAlign(string $labelAlign)                        表单项标签对齐方式，默认右对齐，仅在 mode为horizontal 时生效
 * @method $this labelRemark($labelRemark)                             表单项标签描述
 * @method $this description($description)                             表单项描述
 * @method $this placeholder(string $placeholder)                      表单项描述
 * @method $this requiredOn(string $requiredOn)                        通过表达式来配置当前表单项是否为必填。
 * @method $this validations(string $validations)                      表单项值格式验证，支持设置多个，多个规则用英文逗号隔开。
 * @method $this validateApi($validateApi)                             表单校验接口
 * @method $this autoFill($autoFill)                                   数据录入配置，自动填充或者参照录入
 * @method $this static(bool $static)                                  数据录入配置，自动填充或者参照录入
 * @method $this staticClassName(string $staticClassName)              静态展示时的类名
 * @method $this staticLabelClassName(string $staticLabelClassName)    静态展示时的 Label 的类名
 * @method $this staticInputClassName(string $staticInputClassName)    静态展示时的 Value 的类名
 * @method $this staticSchema($staticSchema)                           自定义静态展示方式
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class FormItem extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-text';

    /**
     * construct amis input
     * @param string|null $name
     * @param string|null $label
     */
    public function __construct(?string $name = null, ?string $label = null)
    {
        parent::__construct();
        !is_null($name) && $this->set('name', $name);
        !is_null($label) && $this->set('label', $label);
    }

    /**
     * 指定表单项类型 参考类型 https://baidu.github.io/amis/zh-CN/components/form/formitem#%E6%94%AF%E6%8C%81%E9%9D%99%E6%80%81%E5%B1%95%E7%A4%BA%E7%9A%84%E8%A1%A8%E5%8D%95%E9%A1%B9
     * @param string $type 表单类型
     * @return FormItem
     */
    public function type(string $type): FormItem
    {
        return $this->set('type', $type);
    }

    /**
     * 是否为必填
     * @param bool $required
     * @return FormItem
     */
    public function required(bool $required = true): FormItem
    {
        return $this->set('required', $required);
    }

    /**
     * 是否为 内联 模式
     * @default false
     * @param bool $inline
     * @return FormItem
     */
    public function inline(bool $inline = true): FormItem
    {
        return $this->set('inline', $inline);
    }

    /**
     * 是否该表单项值发生变化时就提交当前表单。
     * @default false
     * @param bool $submitOnChange
     * @return FormItem
     */
    public function submitOnChange(bool $submitOnChange = true): FormItem
    {
        return $this->set('submitOnChange', $submitOnChange);
    }

    /**
     * 表单大小
     * @default md
     * @param string $size sm | md
     * @return FormItem
     * @throws RendererException
     */
    public function size(string $size): FormItem
    {
        if (!in_array($size, ['sm', 'md'])) {
            throw new RendererException('Switch size only supports sm or md');
        }
        return $this->set('size', $size);
    }
}