<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\BaseRenderer;

/**
 * Antd Collapse
 * @link https://ant.design/components/collapse-cn#collapse
 * @method $this collapsible(string $value)                             是否可折叠或指定可折叠触发区域	header | icon | disabled
 * @method $this key(string|int $value)                                 对应 activeKey
 * @method $this label(string $value)                                   面板标题
 * @method $this extra(array|object $value)                             自定义渲染每个面板右上角的内容
 * @method $this styles(array $value)                                   语义化结构 style
 */
class CollapseItem extends BaseRenderer
{

    /**
     * @param string $key
     * @param string $label
     */
    public function __construct(string $key, string $label)
    {
        $this->set('key', $key)->set('label', $label);
    }

    /**
     * 被隐藏时是否渲染 body 区域 DOM 结构
     * @param bool $force
     * @return self
     */
    public function forceRender(bool $force = true): self
    {
        return $this->set('forceRender', $force);
    }

    /**
     * 是否展示当前面板上的箭头（为 false 时，collapsible 不能设为 icon）
     * @param bool $force
     * @return self
     */
    public function showArrow(bool $force = true): self
    {
        return $this->set('showArrow', $force);
    }

    /**
     * body 区域内容
     * @param array|object|string $children
     * @return self
     */
    public function children(array|object|string $children): self
    {
        return $this->set('children', $children);
    }
}