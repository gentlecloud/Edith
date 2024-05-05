<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form JSONSchema
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/json-schema
 * @method $this schema($schema)                        指定 json-schema    object | string
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class JsonSchema extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'json-schema';
}