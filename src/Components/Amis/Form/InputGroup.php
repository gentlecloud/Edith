<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputGroup 输入框组合
 * 输入框组合选择器 可用于输入框与其他组件进行组合。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-group
 * @method $this validationConfig(array $validationConfig)                  校验相关配置, 具体配置属性如
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputGroup extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-group';
}