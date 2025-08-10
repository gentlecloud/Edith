<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Carousel
 * @link
 * @method $this autoplaySpeed(int $value)                              自动切换的间隔（毫秒）
 * @method $this dotPosition(string $value)                             面板指示点位置，可选 top bottom left right
 * @method $this speed(int $value)                                      切换动效的时间（毫秒）
 * @method $this easing(string $value)                                  动画效果
 * @method $this effect(string $value)                                  动画效果函数 scrollx | fade
 */
class Carousel extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'carousel';

    /**
     * 是否显示箭头
     * @param bool $value
     * @return self
     */
    public function arrows(bool $value = true): self
    {
        return $this->set('arrows', $value);
    }

    /**
     * 是否自动切换，如果为 object 可以指定 dotDuration 来展示指示点进度条	boolean | { dotDuration?: boolean }
     * @param bool|array $value
     * @return self
     */
    public function autoplay(bool|array $value = true): self
    {
        return $this->set('autoplay', $value);
    }

    /**
     * 高度自适应
     * @param bool $value
     * @return self
     */
    public function adaptiveHeight(bool $value = true): self
    {
        return $this->set('adaptiveHeight', $value);
    }

    /**
     * 是否显示面板指示点，如果为 object 则可以指定 dotsClass	boolean | { className?: string }
     * @param bool|array $value
     * @return self
     */
    public function dots(bool|array $value = true): self
    {
        return $this->set('dots', $value);
    }

    /**
     * 是否启用拖拽切换
     * @param bool $value
     * @return self
     */
    public function draggable(bool $value = true): self
    {
        return $this->set('draggable', $value);
    }

    /**
     * 使用渐变切换动效
     * @param bool $value
     * @return self
     */
    public function fade(bool $value = true): self
    {
        return $this->set('fade', $value);
    }

    /**
     * 是否无限循环切换（实现方式是复制两份 children 元素，如果子元素有副作用则可能会引发 bug）
     * @param bool $value
     * @return self
     */
    public function infinite(bool $value = true): self
    {
        return $this->set('infinite', $value);
    }

    /**
     * 是否等待切换动画
     * @param bool $value
     * @return self
     */
    public function waitForAnimate(bool $value = true): self
    {
        return $this->set('waitForAnimate', $value);
    }
}