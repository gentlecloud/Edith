<?php
namespace Edith\Admin\Components\Actions;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Traits\Attributes\ActionTipAttribute;

/**
 * Antd Tooltip
 * @link https://ant.design/components/tooltip-cn
 * @method $this title(string $value)                       提示文字
 */
class Tooltip extends EngineRenderer
{
    use ActionTipAttribute;

    /**
     * @var string
     */
    protected string $renderer = 'tooltip';
}