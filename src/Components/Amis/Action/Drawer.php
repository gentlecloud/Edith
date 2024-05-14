<?php
namespace Edith\Admin\Components\Amis\Action;

use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Drawer  抽屉
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/drawer
 * @method $this title(string $title)                            弹出层标题
 * @method $this headerClassName(string $headerClassName)        Drawer 头部 区域的样式类名
 * @method $this bodyClassName(string $bodyClassName)            Drawer body 区域的样式类名 默认： modal-body
 * @method $this footerClassName(string $footerClassName)        Drawer 页脚 区域的样式类名
 * @method $this width($width)                                   容器的宽度，在 position 为 left 或 right 时生效  默认： 500px
 * @method $this height($height)                                 容器的高度，在 position 为 top 或 bottom 时生效  默认： 500px
 * @method $this actions(array $actions)                         可以不设置，默认只有两个按钮。  【确认】和【取消】
 * @method $this data($data)                                     支持 数据映射，如果不设定将默认将触发按钮的上下文中继承数据。
 * @author  Chico, Xiamen Gentle Technology Co., Ltd
 */
class Drawer extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'drawer';

    /**
     * 通过拖拽改变 Drawer 大小
     * @var bool
     */
    protected bool $resizable = true;

    /**
     * 指定 drawer 大小
     * @param string $size xs、sm、md、lg、xl、full
     * @return $this
     * @throws \Exception
     */
    public function size(string $size): Drawer
    {
        if (!in_array($size, ['xs','sm','md','lg','xl','full'])) {
            throw new \Exception("Dialog size only supports 'xs','sm','md','lg','xl','full'");
        }
        return $this->set('size', $size);
    }

    /**
     * @param string $position left、right、top、bottom
     * @return Drawer
     * @throws RendererException
     */
    public function position(string $position): Drawer
    {
        if (!in_array($position, ['left', 'right', 'top', 'bottom'])) {
            throw new RendererException("Drawer position only supports left、right、top、bottom");
        }
        return $this->set('position', $position);
    }

    /**
     * 是否展示关闭按钮，当值为 false 时，默认开启 closeOnOutside
     * @default true
     * @param bool $showCloseButton
     * @return Drawer
     */
    public function showCloseButton(bool $showCloseButton = true): Drawer
    {
        return $this->set('showCloseButton', $showCloseButton);
    }

    /**
     * 是否支持按 Esc 关闭 Drawer
     * @default false
     * @param bool $closeOnEsc
     * @return Drawer
     */
    public function closeOnEsc(bool $closeOnEsc = true): Drawer
    {
        return $this->set('closeOnEsc', $closeOnEsc);
    }

    /**
     * 点击内容区外是否关闭 Drawer
     * @default false
     * @param bool $closeOnOutside
     * @return Drawer
     */
    public function closeOnOutside(bool $closeOnOutside = true): Drawer
    {
        return $this->set('closeOnOutside', $closeOnOutside);
    }

    /**
     * 是否显示蒙层
     * @default true
     * @param bool $overlay
     * @return Drawer
     */
    public function overlay(bool $overlay = true): Drawer
    {
        return $this->set('overlay', $overlay);
    }

    /**
     * 是否可通过拖拽改变 Drawer 大小
     * @default flase
     * @param bool $resizable
     * @return Drawer
     */
    public function resizable(bool $resizable = true): Drawer
    {
        return $this->set('resizable', $resizable);
    }
}