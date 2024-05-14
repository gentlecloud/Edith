<?php
namespace Edith\Admin\Components\Amis\Table;

use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Crud columns-toggler
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/crud#columns-toggler-%E5%B1%9E%E6%80%A7%E8%A1%A8
 * @method $this label(string $label)                           按钮文字
 * @method $this tooltip(string $tooltip)                       按钮提示文字
 * @method $this disabledTip(string $disabledTip)               按钮禁用状态下的提示
 * @method $this level(string $level)                           按钮样式，参考按钮 默认： default
 * @method $this icon(string $icon)                             按钮的图标
 * @method $this btnClassName(string $btnClassName)             按钮的 CSS 类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Toggler extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'columns-toggler';

    /**
     * 列对齐
     * @param string $align "left" | "right"
     * @return Toggler
     * @throws RendererException
     */
    public function align(string $align): Toggler
    {
        if (!in_array($align, ["left" | "right"])) {
            throw new RendererException("Columns-toggler only supports left or right");
        }
        return $this->set('align', $align);
    }

    /**
     * 按钮大小，参考按钮
     * @param string $size "xs" | "sm" | "md" | "lg"
     * @return Toggler
     * @throws RendererException
     */
    public function size(string $size): Toggler
    {
        if (!in_array($size, ["xs", "sm", "md", "lg"])) {
            throw new RendererException("Columns-toggler only supports xs, sm, md or lg");
        }
        return $this->set('size', $size);
    }

    /**
     * 弹窗底部按钮大小，参考按钮
     * @param string $footerBtnSize "xs" | "sm" | "md" | "lg"
     * @return Toggler
     * @throws RendererException
     */
    public function footerBtnSize(string $footerBtnSize): Toggler
    {
        if (!in_array($footerBtnSize, ["xs", "sm", "md", "lg"])) {
            throw new RendererException("Columns-toggler only supports xs, sm, md or lg");
        }
        return $this->set('footerBtnSize', $footerBtnSize);
    }

    /**
     * 是否可通过拖拽排序
     * @default false
     * @param bool $draggable
     * @return Toggler
     */
    public function draggable(bool $draggable = true): Toggler
    {
        return $this->set('draggable', $draggable);
    }

    /**
     * 默认是否展开
     * @default false
     * @param bool $defaultIsOpened
     * @return Toggler
     */
    public function defaultIsOpened(bool $defaultIsOpened = true): Toggler
    {
        return $this->set('defaultIsOpened', $defaultIsOpened);
    }

    /**
     * 是否隐藏展开的图标
     * @default true
     * @param bool $hideExpandIcon
     * @return Toggler
     */
    public function hideExpandIcon(bool $hideExpandIcon = true): Toggler
    {
        return $this->set('hideExpandIcon', $hideExpandIcon);
    }

    /**
     * 是否显示遮罩层
     * @default false
     * @param bool $overlay
     * @return Toggler
     */
    public function overlay(bool $overlay = true): Toggler
    {
        return $this->set('overlay', $overlay);
    }

    /**
     * 点击外部是否关闭
     * @param bool $closeOnOutside
     * @return Toggler
     */
    public function closeOnOutside(bool $closeOnOutside = true): Toggler
    {
        return $this->set('closeOnOutside', $closeOnOutside);
    }

    /***
     * 点击内容是否关闭
     * @param bool $closeOnClick
     * @return Toggler
     */
    public function closeOnClick(bool $closeOnClick = true): Toggler
    {
        return $this->set('closeOnClick', $closeOnClick);
    }

    /***
     * 是否只显示图标。
     * @default false
     * @param bool $iconOnly
     * @return Toggler
     */
    public function iconOnly(bool $iconOnly = true): Toggler
    {
        return $this->set('iconOnly', $iconOnly);
    }
}