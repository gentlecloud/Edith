<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\AmisRenderer;

/***
 * Amis Markdown 渲染
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/markdown
 * @method $this name(string $name)                名称
 * @method $this value(string $value)              静态值
 * @method $this src($src)                         外部地址 string | API
 * @method $this options(array $options)           高级配置
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Markdown extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'markdown';
}