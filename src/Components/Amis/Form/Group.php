<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Group 表单项组
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/group
 * @method $this label(string $label)                                       group 的标签
 * @method $this mode(string $mode)                                         展示默认，同 Form 中的模式
 * @method $this gap(string $gap)                                           表单项之间的间距，可选：xs、sm、normal
 * @method $this direction(string $direction)                               可以配置水平展示还是垂直展示。对应的配置项分别是：vertical、horizontal  默认： horizontal\
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn
 */
class Group extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'group';
}