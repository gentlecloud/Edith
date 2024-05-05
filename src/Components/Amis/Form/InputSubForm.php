<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputSubForm 子表单
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-sub-form
 * @method $this labelField(string $labelField)                    当值中存在这个字段，则按钮名称将使用此字段的值来展示。
 * @method $this btnLabel(string $btnLabel)                        按钮默认名称 默认： '设置'
 * @method $this minLength(int $minLength)                         限制最小个数。 默认： 0
 * @method $this maxLength(int $maxLength)                         限制最大个数。 默认： 0
 * @method $this addButtonClassName(string $addButtonClassName)    新增按钮 CSS 类名
 * @method $this itemClassName(string $itemClassName)              值元素 CSS 类名
 * @method $this itemsClassName(string $itemsClassName)            值包裹元素 CSS 类名
 * @method $this form($form)                                       子表单配置，同 Form
 * @method $this addButtonText(string $addButtonText)              自定义新增一项的文本
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputSubForm extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-sub-form';

    /**
     * 是否为多选模式
     * @default false
     * @param bool $multiple
     * @return InputSubForm
     */
    public function multiple(bool $multiple = true): InputSubForm
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 是否可拖拽排序
     * @param bool $draggable
     * @return InputSubForm
     */
    public function draggable(bool $draggable = true): InputSubForm
    {
        return $this->set('draggable', $draggable);
    }

    /**
     * 是否可新增
     * @param bool $addable
     * @return InputSubForm
     */
    public function addable(bool $addable = true): InputSubForm
    {
        return $this->set('addable', $addable);
    }

    /**
     * 是否可删除
     * @param bool $removable
     * @return InputSubForm
     */
    public function removable(bool $removable = true): InputSubForm
    {
        return $this->set('removable', $removable);
    }

    /**
     * 是否在左下角显示报错信息
     * @default true
     * @param bool $showErrorMsg
     * @return InputSubForm
     */
    public function showErrorMsg(bool $showErrorMsg = true): InputSubForm
    {
        return $this->set('showErrorMsg', $showErrorMsg);
    }
}