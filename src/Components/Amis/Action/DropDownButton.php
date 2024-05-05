<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\Amis\AmisRenderer;
use Illuminate\Support\Collection;

/**
 * Amis DropDownButton 下拉菜单
 * 参考文档:  https://aisuda.bce.baidu.com/amis/zh-CN/components/dropdown-button
 * @method $this label(string $label)                         按钮文本
 * @method $this btnClassName(string $btnClassName)           按钮 CSS 类名
 * @method $this menuClassName(string $menuClassName)         下拉菜单 CSS 类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class DropDownButton extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'dropdown-button';

    /**
     * 下拉按钮
     * @var Collection
     */
    protected Collection $buttons;

    /**
     * @param string|null $label 按钮文本
     */
    public function __construct(?string $label = null)
    {
        parent::__construct();
        !is_null($label) && $this->set('label', $label);
        $this->buttons = new Collection();
    }

    /**
     * 尺寸
     * @param string $size 'xs' | 'sm' | 'md' | 'lg'
     * @return DropDownButton
     * @throws \Exception
     */
    public function size(string $size): DropDownButton
    {
        if (!in_array($size, ['xs', 'sm', 'md' , 'lg'])) {
            throw new \Exception("DropDownButton size only supports 'xs'、'sm'、'md' or 'lg'");
        }
        return $this->set('size', $size);
    }

    /**
     * 块状样式
     * @param bool $block
     * @return DropDownButton
     */
    public function block(bool $block = true): DropDownButton
    {
        return $this->set('block', $block);
    }

    /**
     * 位置
     * @param string $align left | right
     * @return DropDownButton
     * @throws \Exception
     */
    public function align(string $align): DropDownButton
    {
        if (!in_array($align, [])) {
            throw new \Exception("DropDownButton align only supports 'left' or 'right'");
        }
        return $this->set('align', $align);
    }

    /**
     * 只显示 icon
     * @param bool $iconOnly
     * @return DropDownButton
     */
    public function iconOnly(bool $iconOnly = true): DropDownButton
    {
        return $this->set('iconOnly', $iconOnly);
    }

    /**
     * 默认是否打开
     * @param bool $defaultIsOpened
     * @return DropDownButton
     */
    public function defaultIsOpened(bool $defaultIsOpened = true): DropDownButton
    {
        return $this->set('defaultIsOpened', $defaultIsOpened);
    }

    /**
     * 点击外侧区域是否收起
     * @default true
     * @param bool $closeOnOutside
     * @return DropDownButton
     */
    public function closeOnOutside(bool $closeOnOutside = true): DropDownButton
    {
        return $this->set('closeOnOutside', $closeOnOutside);
    }

    /**
     * 点击按钮后自动关闭下拉菜单
     * @default false
     * @param bool $closeOnClick
     * @return DropDownButton
     */
    public function closeOnClick(bool $closeOnClick = true): DropDownButton
    {
        return $this->set('closeOnClick', $closeOnClick);
    }

    /**
     * 触发方式
     * @default click
     * @param string $trigger click | hover
     * @return DropDownButton
     * @throws \Exception
     */
    public function trigger(string $trigger): DropDownButton
    {
        if (!in_array($trigger, ['click', 'hover'])) {
            throw new \Exception("DropDownButton trigger only supports 'click' or 'hover'");
        }
        return $this->set('trigger', $trigger);
    }

    /**
     * 隐藏下拉图标
     * @default false
     * @param bool $hideCaret
     * @return DropDownButton
     */
    public function hideCaret(bool $hideCaret = true): DropDownButton
    {
        return $this->set('hideCaret', $hideCaret);
    }

    /**
     * 配置下拉按钮
     * @param array|Collection $buttons
     * @return DropDownButton
     */
    public function buttons($buttons): DropDownButton
    {
        if (is_array($buttons)) {
            $buttons = new Collection($buttons);
        }
        return $this->set('buttons', $buttons);
    }

    /**
     * 添加下拉按钮
     * @param string|null $label 子按钮名称
     * @return Button
     */
    public function button(?string $label = null): Button
    {
        return tap(new Button($label), function ($value) {
            $this->buttons->push($value);
        });
    }
}