<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis InputYearRange 年份范围
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-year-range
 * @method $this minDuration(string $minDuration)               限制最小跨度，如： 2year
 * @method $this maxDuration(string $maxDuration)               限制最大跨度，如：4year
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputYearRange extends InputDate
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-year-range';

    /**
     * 是否启用游标动画
     * @default true
     * @param bool $animation
     * @return InputYearRange
     */
    public function animation(bool $animation = true): InputYearRange
    {
        return $this->set('animation', $animation);
    }
}