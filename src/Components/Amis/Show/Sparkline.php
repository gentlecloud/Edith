<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Sparkline 走势图
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/sparkline
 * @method $this name(string $name)                  关联的变量
 * @method $this value($value)
 * @method $this width($width)                       宽度
 * @method $this height($height)                     高度
 * @method $this placeholder(string $placeholder)    数据为空时显示的内容
 */
class Sparkline extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'sparkline';
}