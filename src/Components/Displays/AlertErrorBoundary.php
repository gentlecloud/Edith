<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * @method $this description(string $value)                         自定义错误内容，如果未指定会展示报错堆栈
 * @method $this message(string $value)                             自定义错误标题，如果未指定会展示原生报错信息
 */
class AlertErrorBoundary extends EngineRenderer
{
    /**
     * @var string 
     */
    public string $renderer = 'alert-error-boundary';
}