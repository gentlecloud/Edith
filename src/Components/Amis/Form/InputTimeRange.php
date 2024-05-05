<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis InputTimeRange 时间范围
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-time-range
 * @method $this timeFormat(string $timeFormat)                  时间选择器值格式，更多格式类型请参考 moment
 * @method $this format(string $format)                          选择器值格式，更多格式类型请参考 文档
 * @method $this inputFormat(string $inputFormat)                选择器显示格式，即时间戳格式，更多格式类型请参考 文档
 * @method $this placeholder(string $placeholder)                占位文本 默认： "请选择时间范围"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputTimeRange extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-time-range';

    /**
     * 是否可清除
     * @default true
     * @param bool $clearable
     * @return InputTimeRange
     */
    public function clearable(bool $clearable = true): InputTimeRange
    {
        return $this->set('clearable', $clearable);
    }

    /**
     * 是否内联模式
     * @default false
     * @param bool $embed
     * @return InputTimeRange
     */
    public function embed(bool $embed = true): InputTimeRange
    {
        return $this->set('embed', $embed);
    }

    /**
     * 是否启用游标动画
     * @default true
     * @param bool $animation
     * @return InputTimeRange
     */
    public function animation(bool $animation = true): InputTimeRange
    {
        return $this->set('animation', $animation);
    }
}