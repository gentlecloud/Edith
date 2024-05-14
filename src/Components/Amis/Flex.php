<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Flex 布局
 * Flex 布局是基于 CSS Flex 实现的布局效果，它比 Grid 和 HBox 对子节点位置的可控性更强，比用 CSS 类的方式更易用，并且默认使用水平垂直居中的对齐。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/flex
 * @method Flex justify(string $justify)                            "start", "flex-start", "center", "end", "flex-end", "space-around", "space-between", "space-evenly"
 * @method Flex alignItems(string $alignItems)                      "stretch", "start", "flex-start", "flex-end", "end", "center", "baseline"
 * @method Flex items(array $items)
 * @method Flex direction(string $direction)
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Flex extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'flex';
}