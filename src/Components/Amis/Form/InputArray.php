<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form 数组输入框
 * InputArray 是一种简化的 Combo，用于输入多个某种类型的表单项，提交的时将以数组的形式提交。
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-array
 * @method $this items($items)                               配置单项表单类型
 * @method $this draggableTip(string $draggableTip)          可拖拽的提示文字，默认为："可通过拖动每行中的【交换】按钮进行顺序调整"
 * @method $this addButtonText(string $addButtonText)        新增按钮文字 默认： "新增"
 * @method $this minLength(int $minLength)                   限制最小长度
 * @method $this maxLength(int $maxLength)                   限制最大长度
 * @method $this scaffold($scaffold)                         新增成员时的默认值，一般根据items的数据类型指定需要的默认值
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputArray extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-array';

    /**
     * 是否可新增。
     * @param bool $addable
     * @return InputArray
     */
    public function addable(bool $addable = true): InputArray
    {
        return $this->set('addable', $addable);
    }

    /**
     * 是否可删除
     * @param bool $removable
     * @return InputArray
     */
    public function removable(bool $removable = true): InputArray
    {
        return $this->set('removable', $removable);
    }

    /**
     * 是否可以拖动排序, 需要注意的是当启用拖动排序的时候，会多一个$id 字段
     * @default false
     * @param bool $draggable
     * @return InputArray
     */
    public function draggable(bool $draggable = true): InputArray
    {
        return $this->set('draggable', $draggable);
    }
}