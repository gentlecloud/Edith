<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Container 容器
 * Container 是一种容器组件，它可以渲染其他 amis 组件。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/container
 * @method Container bodyClassName(string $bodyClassName)                         容器内容区的类名
 * @method Container wrapperComponent(string $wrapperComponent = 'div')           容器标签名
 * @method Container style(array $style)                                          自定义样式
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Container extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'container';
}