<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputMonth 月份
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-month
 * @method $this format(string $format)                    月份选择器值格式，更多格式类型请参考 moment
 * @method $this inputFormat(string $inputFormat)          月份选择器显示格式，即时间戳格式，更多格式类型请参考 moment 默认： YYYY-MM
 * @method $this placeholder(string $placeholder)          占位文本
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputMonth extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-month';

    /**
     * 是否可清除
     * @default true
     * @param bool $clearable
     * @return InputMonth
     */
    public function clearable(bool $clearable = true): InputMonth
    {
        return $this->set('clearable', $clearable);
    }
}