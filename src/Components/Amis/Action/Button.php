<?php
namespace Gentle\Edith\Components\Amis\Action;

/**
 * Amis Button 按钮
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/button
 * @method $this loadingOn(string $loadingOn)                          显示按钮 loading 表达式
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Button extends Action
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'button';

    /**
     * 显示按钮 loading 效果
     * @default false
     * @param bool $loading
     * @return Button
     */
    public function loading(bool $loading = true): Button
    {
        return $this->set('loading', $loading);
    }
}