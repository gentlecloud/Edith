<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis ChartRadios 图表单选框
 * 图表点选功能，用来做多个图表联动。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/chart-radios
 * @method $this config(array $config)                      echart 图表配置
 * @method $this chartValueField(string $chartValueField)   图表数值字段名 默认： 'value'
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class ChartRadios extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'chart-radios';

    /**
     * 高亮的时候是否显示 tooltip
     * @default false
     * @param bool $showTooltipOnHighlight
     * @return ChartRadios
     */
    public function showTooltipOnHighlight(bool $showTooltipOnHighlight = true): ChartRadios
    {
        return $this->set('showTooltipOnHighlight', $showTooltipOnHighlight);
    }
}