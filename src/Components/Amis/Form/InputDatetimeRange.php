<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form InputDatetimeRange  日期时间范围
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-datetime-range
 * @method $this ranges(array $ranges)                日期范围快捷键 Array<string> 或 string 默认 "yesterday,7daysago,prevweek,thismonth,prevmonth,prevquarter"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputDatetimeRange extends InputDate
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-datetime-range';

    /**
     * 是否启用游标动画
     * @default true
     * @param bool $animation
     * @return $this
     */
    public function animation(bool $animation = true): InputDatetimeRange
    {
        return $this->set('animation', $animation);
    }
}