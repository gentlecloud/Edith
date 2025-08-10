<?php
namespace Edith\Admin\Components\Fields;

use Edith\Admin\Components\EngineRenderer;

class GroupField extends EngineRenderer
{
    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    public string $renderer = 'custom-fields';

    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    public string $component = 'group';
}