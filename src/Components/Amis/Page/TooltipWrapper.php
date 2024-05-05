<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis TooltipWrapper 文字提示容器
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/tooltip
 * @method $this title(string $title)                               文字提示标题
 * @method $this content(string $content)                           文字提示内容, 兼容之前的 tooltip 属性
 * @method $this placement(string $placement)                       文字提示浮层出现位置  "top" | "left" | "right" | "bottom"  默认： "top"
 * @method $this tooltipTheme(string $tooltipTheme)                 主题样式， 默认为 light   "light" | "dark"
 * @method $this offset(array $offset)                              文字提示浮层位置相对偏移量，单位 px  [0, 0]
 * @method $this trigger($trigger)                                  浮层触发方式，支持数组写法["hover", "click"]  默认： "hover"，可选  "hover" | "click" | "focus" | Array<"hover" | "click" | "focus"
 * @method $this mouseEnterDelay(int $mouseEnterDelay)              浮层延迟展示时间，单位 ms
 * @method $this mouseLeaveDelay(int $mouseLeaveDelay)              浮层延迟隐藏时间，单位 ms
 * @method $this wrapperComponent(string $wrapperComponent)         容器标签名 div | span
 * @method $this tooltipStyle($tooltipStyle)                        浮层自定义样式
 * @method $this tooltipClassName(string $tooltipClassName)         文字提示浮层类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class TooltipWrapper extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'tooltip-wrapper';

    /**
     * 是否展示浮层指向箭头
     * @default true
     * @param bool $showArrow
     * @return TooltipWrapper
     */
    public function showArrow(bool $showArrow = true): TooltipWrapper
    {
        return $this->set('showArrow', $showArrow);
    }

    /**
     * 是否鼠标可以移入到浮层中
     * @default true
     * @param bool $enterable
     * @return TooltipWrapper
     */
    public function enterable(bool $enterable = true): TooltipWrapper
    {
        return $this->set('enterable', $enterable);
    }

    /**
     * 是否点击非内容区域关闭提示
     * @default true
     * @param bool $rootClose
     * @return TooltipWrapper
     */
    public function rootClose(bool $rootClose = true): TooltipWrapper
    {
        return $this->set('rootClose', $rootClose);
    }

    /**
     * 内容区是否内联显示
     * @default false
     * @param bool $inline
     * @return TooltipWrapper
     */
    public function inline(bool $inline = true): TooltipWrapper
    {
        return $this->set('inline', $inline);
    }
}