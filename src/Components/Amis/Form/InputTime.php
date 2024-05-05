<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis InputTime 时间
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-time
 * @method $this timeFormat(string $timeFormat)                  时间选择器值格式，更多格式类型请参考 moment
 * @method $this format(string $format)                          选择器值格式，更多格式类型请参考 文档
 * @method $this inputFormat(string $inputFormat)                选择器显示格式，即时间戳格式，更多格式类型请参考 文档
 * @method $this placeholder(string $placeholder)                占位文本
 * @method $this timeConstraints($timeConstraints)
 */
class InputTime extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-time';

    /**
     * 是否可清除
     * @default true
     * @param bool $clearable
     * @return InputTime
     */
    public function clearable(bool $clearable = true): InputTime
    {
        return $this->set('clearable', $clearable);
    }
}