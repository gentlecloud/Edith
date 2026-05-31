<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Statistic
 * @link https://procomponents.ant.design/components/statistic-card
 * @method $this prefix(string|array|object $value)                              设置数值的前缀
 * @method $this suffix(string|array|object $value)                              设置数值的后缀
 * @method $this title(string $value)                                            数值的标题
 * @method $this tip(string $value)                                              标题提示
 * @method $this value(string|int $value)                                        数值内容
 * @method $this icon(string|Iconfont $value)                                    图标
 * @method $this status(string $value)                                           设置状态点，同 Badge 组件 'success', 'processing, 'default', 'error', 'warning'
 * @method $this valueStyle(array $value)                                        设置数值的样式
 * @method $this description(string $value)                                      描述性标签
 * @method $this layout(string $value)                                           布局	horizontal | vertical | inline
 * @method $this trend(string $value)                                            趋势	up | down
 * @method $this decimalSeparator(string $value)                                 设置小数点
 * @method $this groupSeparator(string $value)                                   设置千分位标识符
 * @method $this precision(int $value)                                           数值精度
 */
class Statistic extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'statistic';
}