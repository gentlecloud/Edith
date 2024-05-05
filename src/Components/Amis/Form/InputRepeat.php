<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputRepeatv 重复频率选择器
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-repeat
 * @method $this options(string $options)              可用配置 secondly,minutely,hourly,daily,weekdays,weekly,monthly,yearly  默认：  hourly,daily,weekly,monthly
 * @method $this placeholder(string $placeholder)      当不指定值时的说明。  默认：  不重复
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputRepeat extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-repeat';
}