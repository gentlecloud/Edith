<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputDatetime 日期时间
 * 参考文档：  https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-datetime
 * @method $this timeConstraints()                              请参考 input-time 里的说明
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputDatetime extends InputDate
{
    /**
     * Amis 渲染类型
     * @var string 
     */
    protected string $type = 'input-datetime';
}