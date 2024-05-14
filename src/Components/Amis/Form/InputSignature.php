<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis inputSignature 签名面板
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-signature
 * @method color(string $color)              手写字体颜色
 * @method bgColor(string $color)            面板背景颜色
 * @method clearBtnLabel(string $label)      清空按钮名称
 * @method undoBtnLabel(string $label)       撤销按钮名称
 * @method confirmBtnLabel(string $label)    确认按钮名称
 * @method embedConfirmLabel(string $label)  内嵌容器确认按钮名称
 * @method ebmedCancelLabel(string $label)   内嵌容器取消按钮名称
 * @method embedBtnIcon(string $icon)        内嵌按钮图标
 * @method embedBtnLabel(string $label)      内嵌按钮文案
 */
class InputSignature extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-signature';

    /**
     * @param bool $embed
     * @return InputSignature
     */
    public function embed(bool $embed = true)
    {
        return $this->set('embed', $embed);
    }
}