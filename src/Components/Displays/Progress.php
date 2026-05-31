<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Progress
 * @method $this percent(int $value)                               百分比
 * @method $this status(string $value)                             状态，可选：success exception normal active(仅限 line)
 * @method $this strokeColor(string|array $value)                  进度条的色彩 传入 object 时为渐变，当有 steps 时支持传入一个数组。 string | string[] | { from: string; to: string; direction: string }
 * @method $this strokeLinecap(string $value)                      进度条的样式
 * @method $this success(array $value)                             成功进度条相关配置	{ percent: number, strokeColor: string }
 * @method $this trailColor(string $value)                         未完成的分段的颜色
 * @method $this type(string $value)                               类型，可选 line circle dashboard
 * @method $this size(string|int|array $value)                     进度条的尺寸	number | [number | string, number] | { width: number, height: number } | "small" | "default"
 * @method $this steps(int $value)                                 进度条总共步数 type = 'line' | 'circle'
 * @method $this percentPosition(array $value)                     进度数值位置，传入对象，align 表示数值的水平位置，type 表示数值在进度条内部还是外部	{ align: string; type: string }
 * @method $this strokeWidth(int $value)                           圆形进度条线的宽度，单位是进度条画布宽度的百分比 type = 'circle' | 'dashboard' 仪表盘进度条线的宽度，单位是进度条画布宽度的百分比
 * @method $this gapDegree(int $value)                             仪表盘进度条缺口角度，可取值 0 ~ 295 type = 'dashboard'
 * @method $this gapPosition(int $value)                           仪表盘进度条缺口位置	top | bottom | left | right
 */
class Progress extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'progress';

    /**
     * 是否显示进度数值或状态图标
     * @param bool $value
     * @return self
     * @default true
     */
    public function showInfo(bool $value): self
    {
        return $this->set('showInfo', $value);
    }
}