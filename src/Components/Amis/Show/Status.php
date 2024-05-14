<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Status 状态
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/status
 * @method $this placeholder(string $placeholder)                          占位文本
 * @method $this map(array $map)                                          映射图标
 * @method $this labelMap(array $labelMap)                                映射文本
 * @method $this source(array $source)                                    自定义映射状态，支持数据映射
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Status extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'status';
}