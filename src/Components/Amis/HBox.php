<?php
namespace Gentle\Edith\Components\Amis;

use Gentle\Edith\Exceptions\RendererException;

/**
 * HBox 布局
 * @method $this columns(array $columns)                       列集合
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class HBox extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'hbox';

    /**
     * 水平间距
     * @param string $gap 'xs' | 'sm' | 'base' | 'none' | 'md' | 'lg'
     * @return $this
     * @throws RendererException
     */
    public function gap(string $gap): HBox
    {
        if (!in_array($gap, ['xs', 'sm', 'base', 'none', 'md', 'lg'])) {
            throw new RendererException("Grid gap only supports 'xs' | 'sm' | 'base' | 'none' | 'md' | 'lg'");
        }
        return $this->set('gap', $gap);
    }

    /**
     * 垂直对齐方式
     * @param string $valign 'top' | 'middle' | 'bottom' | 'between'
     * @return $this
     * @throws RendererException
     */
    public function valign(string $valign): HBox
    {
        if (!in_array($valign, ['top', 'middle', 'bottom', 'between'])) {
            throw new RendererException("Grid valign only supports 'top' | 'middle' | 'bottom' | 'between'");
        }
        return $this->set('valign', $valign);
    }

    /**
     * 水平对齐方式
     * @param string $align 'left' | 'right' | 'between' | 'center'
     * @return $this
     * @throws RendererException
     */
    public function align(string $align): HBox
    {
        if (!in_array($align, ['left', 'right', 'between', 'center'])) {
            throw new RendererException("Grid align only supports 'left' | 'right' | 'between' | 'center'");
        }
        return $this->set('align', $align);
    }
}