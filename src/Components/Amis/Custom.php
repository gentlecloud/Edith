<?php
namespace Gentle\Edith\Components\Amis;

/**
 * Amis Custom  自定义组件
 * 用于实现自定义组件，它解决了之前 JS SDK 和可视化编辑器中难以支持自定义组件的问题。
 * 参考文档：  https://aisuda.bce.baidu.com/amis/zh-CN/components/custom
 * @method $this id(string $id)                          节点 id
 * @method $this name(string $name)                      节点 名称
 * @method $this inline(bool $inline)                    默认使用 div 标签，如果 true 就使用 span 标签 默认： false
 * @method $this html(string $html)                      初始化节点 html
 * @method $this onMount(string $onMount)                节点初始化之后调的用函数
 * @method $this onUpdate(string $onUpdate)              数据有更新的时候调用的函数
 * @method $this onUnmount(string $onUnmount)            节点销毁的时候调用的函数
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Custom extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'custom';
}