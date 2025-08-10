<?php
namespace Edith\Admin\Components;

use Edith\Admin\Components\Traits\Attributes\RendererAttribute;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Str;

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
     * 各类 Antd 适合的场景均可用 如 fields columns 等
     * @param numeric-string|int $width 宽度, 支持了一些枚举 "xs" | "sm" | "md" | "lg" | "xl"
     * @return $this
     * @throws RendererException
     */
    public function width(string|int $width): static
    {
        if (!is_numeric($width) && !Str::contains($width, '%') && !Str::contains($width, 'px') && !in_array($width, ["xs" , "sm" , "md" ,"lg" , "xl"])) {
            throw new RendererException("Width only supports setting 'xs', 'sm', 'md', 'lg', 'xl'");
        }
        return $this->set('width', $width);
    }

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