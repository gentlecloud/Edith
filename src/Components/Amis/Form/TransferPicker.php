<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis TransferPicker 穿梭选择器
 * 在穿梭器（Transfer）的基础上扩充了弹窗选择模式，展示值用的是简单的 input 框，但是编辑的操作是弹窗个穿梭框来完成。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/transfer-picker
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class TransferPicker extends Transfer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'transfer-picker';
}