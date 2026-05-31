<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Statistic.Timer
 * @link https://ant.design/components/statistic-cn
 * @method $this type(string $value)                                计时类型，正计时或者倒计时	countdown countup
 * @method $this format(string $value)                              格式化倒计时展示，参考 dayjs
 * @method $this prefix(string|array|object $value)                 设置数值的前缀
 * @method $this suffix(string|array|object $value)                 设置数值的后缀
 * @method $this title(string $value)                               数值的标题
 * @method $this value(int|string $value)                           数值内容
 * @method $this valueStyle(array $value)                           设置数值区域的样式
 */
class StatisticTimer extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'statistic_timer';
}