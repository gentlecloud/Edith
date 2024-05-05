<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Alert 提示
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/alert
 * @method $this closeButtonClassName(string $closeButtonClassName)       关闭按钮的 CSS 类名
 * @method $this icon(string $icon)                                       自定义 icon
 * @method $this iconClassName(string $iconClassName)                     icon 的 CSS 类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Alert extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'alert';

    /**
     * 角标级别, 设置之后角标背景颜色不同
     * @param string $level info | success | warning | danger
     * @return $this
     * @throws \Exception
     */
    public function level(string $level): Alert
    {
        if (!in_array($level, ['info', 'success', 'warning', 'danger'])) {
            throw new \Exception("Alert level only supports 'info', 'success', 'warning', 'danger'");
        }
        return $this->set('level', $level);
    }

    /**
     * 是否显示关闭按钮
     * @default false
     * @param bool $showCloseButton
     * @return Alert
     */
    public function showCloseButton(bool $showCloseButton = true): Alert
    {
        return $this->set('showCloseButton', $showCloseButton);
    }

    /**
     * 是否显示 icon
     * @default false
     * @param bool $showIcon
     * @return Alert
     */
    public function showIcon(bool $showIcon = true): Alert
    {
        return $this->set('showIcon', $showIcon);
    }
}