<?php
namespace Gentle\Edith\Components\Displays;

use Gentle\Edith\Components\Renderer;

/**
 * @method $this type(string $icon)
 */
class Iconfont extends Renderer
{
    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    protected string $component = 'iconfont';

    /**
     * Ant Iconfont 图标
     * @var string
     */
    protected string $type = '';

    public function __construct(?string $type = null)
    {
        parent::__construct();
        !is_null($type) && $this->set('type', $type);
    }

    public function render(): array
    {
        return parent::render(); // TODO: Change the autogenerated stub
    }
}