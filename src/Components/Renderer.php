<?php
namespace Edith\Admin\Components;

use Edith\Admin\Components\Contracts\RendererInterface;
use Edith\Admin\Components\Traits\Attributes\RendererAttribute;

/**
 * Edith Renderer
 * 翼搭前端 UI 渲染组件
 * @method static $this renderer(string $renderer)        翼搭 UI 渲染器
 * @method $this className(string $className)             配置外层 dom 类名
 * @method $this body($body)                              当前页面内容
 * @method $this style(array $style)                      自定义样式
 * @method $this md(int $md)                              Grid 响应式 通过 md 设置屏幕中等宽度（768px）情况下的分栏
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
abstract class Renderer implements RendererInterface
{
    use RendererAttribute;

    /**
     * 定义翼搭前端 UI 渲染器
     * @var string
     */
    protected string $renderer = 'edith';

    /**
     * 渲染器唯一标识
     * @var string|null
     */
    protected ?string $uniqid;

    /**
     * construct renderer class
     */
    public function __construct()
    {
        $this->uniqid();
    }

    /**
     * 设置 Engine 渲染器唯一标识
     * @param string|null $key
     * @return $this
     */
    public function uniqid(?string $key = null): RendererInterface
    {
        is_null($key) && $key = uniqid(mt_rand(), true);
        $this->set('uniqid', md5($key));
        return $this;
    }

    /**
     * 操作后舔砖 http(s):// or Edith Engine
     * @param string $url 跳转链接或翼搭 engine 路径
     * @param bool $engine 使用翼搭引擎， 当跳转为 engine 时，必须为 true
     * @return RendererInterface
     */
    public function redirect(string $url, bool $engine = true): RendererInterface
    {
        if ($engine && !str_contains(substr($url, 0, 7), 'engine')) {
            $url = "{$url}";
        }
        $this->set('redirect', $url);
        return $this;
    }

    /**
     * 
     * @return $this
     */
    public static function make(): RendererInterface
    {
        return (new static);
    }

    /**
     * 静态调用
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
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
     * 序列化翼搭 UI 组件
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->render();
    }
}