<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Progress 进度条
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/progress
 * @method $this mode(string $mode)                                进度「条」的类型，可选 line | circle | dashboard 默认： line
 * @method $this value($value)                                     进度值
 * @method $this placeholder(string $placeholder)                  占位文本 默认： '-'
 * @method $this map(array $map)                                   进度颜色映射 默认： ['bg-danger', 'bg-warning', 'bg-info', 'bg-success', 'bg-success']
 * @method $this threshold(array $threshold)                       阈值（刻度） {value:模板, color?:模板} | Array<{value:模板, color?:模板}>
 * @method $this valueTpl(string $valueTpl)                        自定义格式化内容 默认 ： ${value}%
 * @method $this strokeWidth(int $strokeWidth)                     进度条线宽度 默认： line 类型为10，circle、dashboard 类型为6
 * @method $this gapDegree(int $gapDegree)                         仪表盘缺角角度，可取值 0 ~ 295 默认： 75
 * @method $this gapPosition(string $gapPosition)                  仪表盘进度条缺口位置，可选 top | bottom | left | right  默认： bottom
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Progress extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'progress';

    /**
     * 是否展示进度文本 默认： true
     * @default true
     * @param bool $showLabel
     * @return Progress
     */
    public function showLabel(bool $showLabel = true): Progress
    {
        return $this->set('showLabel', $showLabel);
    }

    /**
     * 背景是否显示条纹
     * @default false
     * @param bool $stripe
     * @return Progress
     */
    public function stripe(bool $stripe = true): Progress
    {
        return $this->set('stripe', $stripe);
    }

    /**
     * type 为 line，可支持动画
     * @default false
     * @param bool $animate
     * @return Progress
     */
    public function animate(bool $animate = true): Progress
    {
        return $this->set('animate', $animate);
    }

    /**
     * 是否显示阈值（刻度）数值
     * @default false
     * @param bool $showThresholdText
     * @return Progress
     */
    public function showThresholdText(bool $showThresholdText = true): Progress
    {
        return $this->set('showThresholdText', $showThresholdText);
    }
}