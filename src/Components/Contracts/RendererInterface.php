<?php
namespace Edith\Admin\Components\Contracts;

use JsonSerializable;

/**
 * @method static RendererInterface renderer(string $renderer)        翼搭 UI 渲染 Component
 * @method static RendererInterface type(string $type)                  设置当前页面类型
 * @method RendererInterface className(string $className)        配置外层 dom 类名
 * @method RendererInterface body($body)                         当前页面内容
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
interface RendererInterface extends JsonSerializable
{
    /**
     * 设置 UI Engine React 组件 Key
     * @param string|null $key
     * @return RendererInterface
     */
    public function uniqid(?string $key = null): RendererInterface;

    /**
     * 设置属性
     * @param string $name 属性名
     * @param string|array|object|null $value 属性值
     * @return $this
     */
    public function set(string $name, $value);

    /**
     * 渲染组件
     * @return array
     */
    public function render(): array;
}