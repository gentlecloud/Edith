<?php
namespace Edith\Admin\Components;

use Edith\Admin\Components\Contracts\RendererInterface;
use Edith\Admin\Components\Traits\RendererAttribute;

/**
 * Edith Basic Renderer
 * @method $this style(array $style)                          当前组件样式
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
abstract class BaseRenderer implements \JsonSerializable
{
    use RendererAttribute;

    /**
     *
     * @return $this
     */
    public static function make()
    {
        return (new static);
    }

    /**
     * 渲染组件
     * @return array
     */
    public function render(): array
    {
        return get_object_vars($this);
    }

    /**
     * 序列化组件
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->render();
    }
}