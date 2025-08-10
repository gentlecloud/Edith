<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Traits\Attributes\TypographyAttribute;

class Title extends EngineRenderer
{
    use TypographyAttribute;

    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    protected string $renderer = 'typography';

    /**
     * @var string
     */
    protected string $component = 'title';

    /**
     * @param string|null $text
     * @param string|null $type
     */
    public function __construct(?string $text = null, ?string $type = null)
    {
        parent::__construct();
        !is_null($text) && $this->set('text', $text);
        !is_null($type) && $this->set('type', $type);
    }

    /**
     * 重要程度，相当于 h1、h2、h3、h4、h5
     * @param int $level
     * @return self
     */
    public function level(int $level): self
    {
        return $this->set('level', $level);
    }
}