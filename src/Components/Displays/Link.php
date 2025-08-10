<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Traits\Attributes\TypographyAttribute;

/**
 * @method $this href(string $value)                       跳转链接
 * @method $this target(string $value)                     跳转方式
 */
class Link extends EngineRenderer
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
    protected string $component = 'link';

    /**
     * @param string|null $text
     * @param string|null $href
     */
    public function __construct(?string $text = null, ?string $href = null)
    {
        parent::__construct();
        !is_null($text) && $this->set('text', $text);
        !is_null($href) && $this->set('href', $href);
    }
}