<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * @method $this type(string $value)                                分隔类型	horizontal | vertical
 */
class StatisticDivider extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'statistic-divider';
}