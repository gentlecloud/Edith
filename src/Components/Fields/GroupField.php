<?php
namespace Edith\Admin\Components\Fields;

use Edith\Admin\Components\EngineRenderer;

/**
 * @method $this title(string $title)
 */
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

    /**
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        parent::__construct();
        !is_null($title) && $this->set('title', $title);
    }

    /**+
     * @param bool $collapsible
     * @return self
     */
    public function collapsible(bool $collapsible = true): self
    {
        return $this->set('collapsible', $collapsible);
    }
}