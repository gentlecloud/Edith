<?php
namespace Edith\Admin\Components;

use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Str;

/**
 * @method $this id(string $id)                                             HTML ID
 * @method $this component(string $component)                               渲染器部件类型
 * @method $this rootClassName(string $className)                           添加在组件最外层的 className
 * @method $this data(array $data)                                          层级 Data
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
abstract class EngineRenderer extends Renderer
{

    /**
     * 设置组件 scopeName 用于刷新，上下文隔离
     * @param string $scopeName
     * @return $this
     */
    public function scopeName(string $scopeName): self
    {
        return $this->set('edith_scope_name', $scopeName);
    }

    /**
     * 各类 Antd 适合的场景均可用 如 fields columns 等
     * @param numeric-string|int $width 宽度, 支持了一些枚举 "xs" | "sm" | "md" | "lg" | "xl"
     * @return $this
     * @throws RendererException
     */
    public function width(string|int $width): self
    {
        if (!is_numeric($width) && !Str::contains($width, '%') && !Str::contains($width, 'px') && !in_array($width, ["xs" , "sm" , "md" ,"lg" , "xl"])) {
            throw new RendererException("Width only supports setting 'xs', 'sm', 'md', 'lg', 'xl'");
        }
        return $this->set('width', $width);
    }
}