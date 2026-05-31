<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;

/**
 * @method Helmet title(string $title)                               页面 Header 标题
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Helmet extends EngineRenderer
{
    /**
     * 翼搭 UI 渲染 Component
     * @var string
     */
    public string $renderer = 'helmet';
}