<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form InputMonthRange 月份范围
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-month-range
 * @method $this minDuration(string $minDuration)          限制最小跨度，如： 2days
 * @method $this maxDuration(string $maxDuration)          限制最大跨度，如：1year
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputMonthRange extends InputDate
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-month-range';

    /**
     * 是否启用游标动画
     * @default true
     * @param bool $animation
     * @return InputMonthRange
     */
    public function animation(bool $animation = true): InputMonthRange
    {
        return $this->set('animation', $animation);
    }
}
