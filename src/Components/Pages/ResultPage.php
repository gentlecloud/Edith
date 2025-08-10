<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Result
 * @link
 * @method $this extra(string|array|object $extra)                              操作区
 * @method $this icon(string $icon)                                             自定义 icon
 * @method $this status(string $status)                                         结果的状态，决定图标和颜色	success | error | info | warning | 404 | 403 | 500
 * @method $this subTitle(string $subTitle)                                     subTitle 文字
 * @method $this title(string $title)                                           title 文字
 * @method $this errMessage(string $errMessage)                                 简单的错误反馈
 */
class ResultPage extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'result';
}