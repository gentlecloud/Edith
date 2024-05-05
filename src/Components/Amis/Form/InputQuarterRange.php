<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputQuarterRange 季度范围
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-quarter-range
 * @method $this format(string $format)                    日期选择器值格式 默认： X
 * @method $this inputFormat(string $inputFormat)          日期选择器显示格式 默认： YYYY-DD
 * @method $this placeholder(string $placeholder)          占位文本 默认： "请选择季度范围"
 * @method $this minDate(string $minDate)                  限制最小日期，用法同 限制范围
 * @method $this maxDate(string $maxDate)                  限制最大日期，用法同 限制范围
 * @method $this minDuration(string $minDuration)          限制最小跨度，如： 2quarter
 * @method $this maxDuration(string $maxDuration)          限制最大跨度，如：4quarter
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputQuarterRange extends FormItem
{

    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-quarter-range';

    /**
     * 保存 UTC 值
     * @default false
     * @param bool $utc
     * @return InputQuarterRange
     */
    public function utc(bool $utc = true): InputQuarterRange
    {
        return $this->set('utc', $utc);
    }

    /**
     * 是否可清除
     * @default true
     * @param bool $clearable
     * @return InputQuarterRange
     */
    public function clearable(bool $clearable = true): InputQuarterRange
    {
        return $this->set('clearable', $clearable);
    }

    /**
     * 是否内联模式
     * @default false
     * @param bool $embed
     * @return InputQuarterRange
     */
    public function embed(bool $embed = true): InputQuarterRange
    {
        return $this->set('embed', $embed);
    }

    /**
     * 是否启用游标动画
     * @default true
     * @param bool $animation
     * @return InputQuarterRange
     */
    public function animation(bool $animation = true): InputQuarterRange
    {
        return $this->set('animation', $animation);
    }
}