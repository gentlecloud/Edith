<?php
namespace Edith\Admin\Components\Traits\Attributes;

trait RendererAttribute
{
    /**
     * @param string $rule
     * @return $this
     */
    public function visibleOn(string $rule): static
    {
        return $this->set('visibleOn', $rule);
    }

    /**
     * @param string $rule
     * @return $this
     */
    public function disabledOn(string $rule): static
    {
        return $this->set('disabledOn', $rule);
    }

    /**
     * 设置属性
     * @param string $name 属性名
     * @param array|object|string|null $value 属性值
     * @return $this
     */
    public function set(string $name, $value): static
    {
        $this->$name = $value;
        return $this;
    }

    /**
     * 动态调用
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $this->set($name, array_shift($arguments));
        return $this;
    }
}