<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Tag
 * @link
 * @method $this closeIcon(string|array|object $value)                              自定义关闭按钮。5.7.0：设置为 null 或 false 时隐藏关闭按钮
 * @method $this icon(string|array|object $value)                                   设置图标
 * @method $this color(string $value)                                               标签色
 * @method $this text(string $value)                                                标签文字
 */
class Tag extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'tag';

    /**
     * 是否有边框
     * @param bool $value
     * @return self
     */
    public function bordered(bool $value = true): self
    {
        return $this->set('bordered', $value);
    }
}