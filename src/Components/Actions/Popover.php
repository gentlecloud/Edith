<?php
namespace Edith\Admin\Components\Actions;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Traits\Attributes\ActionTipAttribute;

/**
 * Antd Popover
 * @link https://ant.design/components/popover-cn
 * @method $this content(string $value)                             卡片内容
 * @method $this title(string $value)                               卡片标题
 */
class Popover extends EngineRenderer
{
    use ActionTipAttribute;

    /**
     * @var string
     */
    public string $renderer = 'popover';
}