<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;

/**
 * Edith Wrapper
 * 相当于用 div 包含起来，最大的用处是用来配合 css 进行布局。
 */
class Wrapper extends EngineRenderer
{

    /**
     * @var string
     */
    protected string $renderer = 'wrapper';
}