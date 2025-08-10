<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Traits\Attributes\TypographyAttribute;

class Text extends EngineRenderer
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
    protected string $component = 'text';

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
     * 添加键盘样式
     * @param bool $keyboard
     * @return self
     */
    public function keyboard(bool $keyboard = true): self
    {
        return $this->set('keyboard', $keyboard);
    }
}