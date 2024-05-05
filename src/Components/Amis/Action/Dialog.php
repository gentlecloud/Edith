<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Dialog 对话框
 * Dialog 弹框 主要由 Action 触发，主要展示一个对话框以供用户操作。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/dialog
 * @method $this title(string $title)                                弹出层标题
 * @method $this bodyClassName(string $bodyClassName)                Dialog body 区域的样式类名 默认： modal-body
 * @method $this actions(array $actions)                             如果想不显示底部按钮，可以配置：[]
 * @method $this data($data)                                         支持数据映射，如果不设定将默认将触发按钮的上下文中继承数据。
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Dialog extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'dialog';

    /**
     * 指定 dialog 大小
     * @param string $size xs、sm、md、lg、xl、full
     * @return Dialog
     * @throws \Exception
     */
    public function size(string $size): Dialog
    {
        if (!in_array($size, ['xs','sm','md','lg','xl','full'])) {
            throw new \Exception("Dialog size only supports 'xs','sm','md','lg','xl','full'");
        }
        return $this->set('size', $size);
    }

    /**
     * 是否支持按 Esc 关闭 Dialog
     * @default false
     * @param bool $closeOnEsc
     * @return Dialog
     */
    public function closeOnEsc(bool $closeOnEsc = true): Dialog
    {
        return $this->set('closeOnEsc', $closeOnEsc);
    }

    /**
     * 是否显示右上角的关闭按钮
     * @default true
     * @param bool $showCloseButton
     * @return Dialog
     */
    public function showCloseButton(bool $showCloseButton = true): Dialog
    {
        return $this->set('showCloseButton', $showCloseButton);
    }

    /**
     * 是否在弹框左下角显示报错信息
     * @default true
     * @param bool $showErrorMsg
     * @return Dialog
     */
    public function showErrorMsg(bool $showErrorMsg = true): Dialog
    {
        return $this->set('showErrorMsg', $showErrorMsg);
    }

    /**
     * 是否在弹框左下角显示 loading 动画
     * @default true
     * @param bool $showLoading
     * @return Dialog
     */
    public function showLoading(bool $showLoading = true): Dialog
    {
        return $this->set('showLoading', $showLoading);
    }
}