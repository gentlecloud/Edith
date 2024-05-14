<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\Renderer;

/**
 * @method Helmet title(string $title)                               页面 Header 标题
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Helmet extends Renderer
{
    /**
     * 翼搭 UI 渲染 Component
     * @var string
     */
    protected string $renderer = 'helmet';

    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'edith';
}