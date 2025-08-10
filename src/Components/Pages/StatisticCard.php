<?php
namespace Edith\Admin\Components\Pages;

use Closure;
use Edith\Admin\Components\Displays\Statistic;

/**
 * Antd Pro StatisticCard
 * @link https://procomponents.ant.design/components/statistic-card
 * @method $this chart(array|object $value)                             图表卡片
 * @method $this chartPlacement(string $value)                          图表位置，相对于 statistic 的位置	left | right | bottom
 * @method $this footer(array $value)                                   额外指标展示
 */
class StatisticCard extends ProCard
{
    /**
     * @var string
     */
    protected string $renderer = 'statistic-card';

    /**
     * 数值统计配置，布局默认为 vertical
     * @param array|Statistic|Closure $value
     * @return self
     */
    public function statistic(array|Statistic|\Closure $value): self
    {
        if ($value instanceof Closure) {
            $statistic = new Statistic();
            $value($statistic);
            return $this->set('statistic', $statistic);
        } else {
            return $this->set('statistic', $value);
        }
    }
}