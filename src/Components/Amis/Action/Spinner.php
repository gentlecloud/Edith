<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Spinner 加载中
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/spinner
 * @method $this spinnerClassName(string $spinnerClassName)           组件中 icon 所在标签的自定义 class
 * @method $this spinnerWrapClassName(string $spinnerWrapClassName)   作为容器使用时组件最外层标签的自定义 class
 * @method $this icon(string $icon)                                   组件图标，可以是amis内置图标，也可以是字体图标或者网络图片链接，作为 ui 库使用时也可以是自定义组件
 * @method $this tip(string $tip)                                     配置组件文案，例如加载中...
 * @method $this delay(int $delay)                                    配置组件显示延迟的时间（毫秒） 默认： 0
 * @method $this loadingConfig($loadingConfig)                        为 Spinner 指定挂载的容器, root 是一个selector，在拥有Spinner的组件上都可以通过传递loadingConfig改变Spinner的挂载位置，开启后，会强制开启属性overlay=true
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Spinner extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'spinner';

    /**
     * 是否显示 spinner 组件
     * @default true
     * @param bool $show
     * @return Spinner
     */
    public function show(bool $show = true): Spinner
    {
        return $this->set('show', $show);
    }

    /**
     * 组件大小
     * @param string $size sm | lg
     * @return Spinner
     * @throws \Exception
     */
    public function size(string $size): Spinner
    {
        if (!in_array($size, ['sm', 'lg'])) {
            throw new \Exception("Spinner size only supports 'sm' , 'lg'");
        }
        return $this->set('size', $size);
    }

    /**
     * 配置组件 tip 相对于 icon 的位置
     * @param string $tipPlacement 'top' | 'right' | 'bottom' | 'left'
     * @default bottom
     * @return Spinner
     * @throws \Exception
     */
    public function tipPlacement(string $tipPlacement): Spinner
    {
        if (!in_array($tipPlacement, ['top', 'right', 'bottom', 'left'])) {
            throw new \Exception("Spinner tipPlacement only supports 'top', 'right', 'bottom', 'left'");
        }
        return $this->set('tipPlacement', $tipPlacement);
    }

    /**
     * 配置组件显示 spinner 时是否显示遮罩层
     * @default true
     * @param bool $overlay
     * @return Spinner
     */
    public function overlay(bool $overlay = true): Spinner
    {
        return $this->set('overlay', $overlay);
    }
}