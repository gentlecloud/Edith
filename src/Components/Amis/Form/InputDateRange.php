<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputDateRange日期范围
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-date-range
 * @method $this ranges(array $ranges)                日期范围快捷键 Array<string> 或 string 默认 "yesterday,7daysago,prevweek,thismonth,prevmonth,prevquarter"
 * @method $this minDuration(string $minDuration)     限制最小跨度，如： 2days
 * @method $this maxDuration(string $maxDuration)     限制最大跨度，如：1year
 */
class InputDateRange extends InputDate
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-date-range';

    /**
     * 是否启用游标动画
     * @default true
     * @param bool $animation
     * @return InputDateRange
     */
    public function animation(bool $animation = true): InputDateRange
    {
        return $this->set('animation', $animation);
    }
}