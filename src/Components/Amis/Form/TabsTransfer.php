<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis TabsTransfer 组合穿梭器
 * 在穿梭器（Transfer）的基础上扩充了左边的展示形式，支持 Tabs 的形式展示。对应的 options 的顶级数据，顶层 options 的成员支持 selectMode 配置这个 tab 下面的选项怎么展示。title 可以配置 tab 的标题。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/tabs-transfer
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class TabsTransfer extends Transfer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'tabs-transfer';
}