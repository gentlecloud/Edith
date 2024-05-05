<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Mapping 映射
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/mapping
 * @method $this placeholder(string $placeholder)                       占位文本
 * @method $this map(array $map)                                        映射配置 object或Array<object>
 * @method $this source(string $source)                                 API 或 数据映射
 * @method $this valueField(string $valueField)                         map或source为Array<object>时，用来匹配映射的字段名
 * @method $this labelField(string $labelField)                         map或source为Array<object>时，用来展示的字段名注：配置后映射值无法作为schema组件渲染
 * @method $this itemSchema($itemSchema)                                参考文档介绍
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Mapping extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'mapping';
}