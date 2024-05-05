<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis AnchorNav 锚点导航
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/anchor-nav
 * @method $this linkClassName(string $linkClassName)                               导航 Dom 的类名
 * @method $this sectionClassName(string $sectionClassName)                         锚点区域 Dom 的类名
 * @method $this links(array $links)                                                links 内容
 * @method $this direction(string $direction)                                       可以配置导航水平展示还是垂直展示。对应的配置项分别是：vertical、horizontal  默认 "vertical"
 * @method $this active(string $active)                                             需要定位的区域
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class AnchorNav extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'anchor-nav';
}