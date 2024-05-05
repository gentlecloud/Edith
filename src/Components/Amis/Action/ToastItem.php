<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\BaseRenderer;

/**
 * Amis ToastItem
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/toast#toastitem-%E5%B1%9E%E6%80%A7%E8%A1%A8
 * @method $this title(string $title)                       标题
 * @method $this timeout(int $timeout)                      持续时间
 */
class ToastItem extends BaseRenderer
{
    /**
     * construct toast item
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        !is_null($title) && $this->set('title', $title);
    }

    /**
     * 展示图标，可选'info'、'success'、'error'、'warning'
     * @default info
     * @param string $level info | success | warning | danger
     * @return $this
     * @throws \Exception
     */
    public function level(string $level): ToastItem
    {
        if (!in_array($level, ['info', 'success', 'warning', 'danger'])) {
            throw new \Exception("Alert level only supports 'info', 'success', 'warning', 'danger'");
        }
        return $this->set('level', $level);
    }

    /**
     * 提示显示位置
     * @default top-center（移动端为center）
     * @param string $position 'top-right' | 'top-center' | 'top-left' | 'bottom-center' | 'bottom-left' | 'bottom-right' | 'center'
     * @return $this
     * @throws \Exception
     */
    public function position(string $position): ToastItem
    {
        if (!in_array($position, ['top-right','top-center','top-left','bottom-center','bottom-left','bottom-right','center'])) {
            throw new \Exception("Badge position only supports 'top-right','top-center','top-left','bottom-center','bottom-left','bottom-right','center'");
        }
        return $this->set('position', $position);
    }

    /**
     * 是否展示关闭按钮
     * @default false
     * @param bool $closeButton
     * @return ToastItem
     */
    public function closeButton(bool $closeButton = true): ToastItem
    {
        return $this->set('closeButton', $closeButton);
    }

    /**
     * 是否展示图标
     * @default true
     * @param bool $showIcon
     * @return ToastItem
     */
    public function showIcon(bool $showIcon = true): ToastItem
    {
        return $this->set('showIcon', $showIcon);
    }
}