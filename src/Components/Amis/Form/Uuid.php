<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form UUID 字段
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/uuid
 * @method $this length(int $length)            生成短随机数
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Uuid extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'uuid';
}