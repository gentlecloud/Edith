<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis InputPassword 密码输入框
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-password
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputPassword extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-password';

    /**
     * 是否展示密码显/隐按钮
     * @default true
     * @param bool $revealPassword
     * @return InputPassword
     */
    public function revealPassword(bool $revealPassword = true): InputPassword
    {
        return $this->set('revealPassword', $revealPassword);
    }
}