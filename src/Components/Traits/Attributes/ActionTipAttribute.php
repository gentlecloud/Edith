<?php
namespace Edith\Admin\Components\Traits\Attributes;

/**
 * 以下 API 为 Tooltip、Popconfirm、Popover 共享的 API。
 * @method $this align(array $value)                                该值将合并到 placement 的配置中，设置参考 dom-align
 * @method $this color(string $value)                               背景颜色
 * @method $this mouseEnterDelay(int $value)                        鼠标移入后延时多少才显示 Tooltip，单位：秒
 * @method $this mouseLeaveDelay(int $value)                        鼠标移出后延时多少才隐藏 Tooltip，单位：秒
 * @method $this placement(string $value)                           气泡框位置，可选 top left right bottom topLeft topRight bottomLeft bottomRight leftTop leftBottom rightTop rightBottom	string
 * @method $this trigger(string|array $value)                       触发行为，可选 hover | focus | click | contextMenu，可使用数组设置多个触发行为	string | string[]
 * @method $this zIndex(int $value)                                 设置 Tooltip 的 z-index
 */
trait ActionTipAttribute
{

    /**
     * 修改箭头的显示状态以及修改箭头是否指向目标元素中心	boolean | { pointAtCenter: boolean }
     * @param bool|array $value
     * @return $this
     */
    public function arrow(bool|array $value = true): static
    {
        return $this->set('arrow', $value);
    }

    /**
     * 气泡被遮挡时自动调整位置
     * @param bool $value
     * @return $this
     */
    public function autoAdjustOverflow(bool $value = true): static
    {
        return $this->set('autoAdjustOverflow', $value);
    }

    /**
     * 默认是否显隐
     * @param bool $value
     * @return $this
     */
    public function defaultOpen(bool $value = false): static
    {
        return $this->set('defaultOpen', $value);
    }

    /**
     * 关闭后是否销毁 dom
     * @param bool $value
     * @return $this
     */
    public function destroyOnHidden(bool $value = true): static
    {
        return $this->set('destroyOnHidden', $value);
    }

    /**
     * 默认情况下，Tooltip 在关闭时会缓存内容。设置该属性后会始终保持更新
     * @param bool $value
     * @return $this
     */
    public function fresh(bool $value = true): static
    {
        return $this->set('fresh', $value);
    }
}