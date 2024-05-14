<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Chart 图表
 * chart 配置文档： https://echarts.apache.org/zh/option.html#title
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/chart
 * @method $this api($api)                                          配置项接口地址 string | API
 * @method $this source($source)                                    通过数据映射获取数据链中变量值作为配置
 * @method $this interval(int $interval)                            刷新时间(最小 1000)
 * @method $this config($config)                                    设置 eschars 的配置项,当为string的时候可以设置 function 等配置项 object | string
 * @method $this width(string $width)                               设置根元素的宽度
 * @method $this height(string $height)                             设置根元素的高度
 * @method $this trackExpression(string $trackExpression)           当这个表达式的值有变化时更新图表
 * @method $this dataFilter(string $dataFilter)                     自定义 echart config 转换，函数签名：function(config, echarts, data) {return config;} 配置时直接写函数体。其中 config 是当前 echart 配置，echarts 就是 echarts 对象，data 为上下文数据。
 * @method $this mapURL($mapURL)                                    地图 geo json 地址  string | API
 * @method $this mapName(string $mapName)                           地图名称
 * @author ling
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Chart extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = "chart";

    /**
     * 组件初始化时，是否请求接口
     * @param bool $initFetch
     * @return Chart
     */
    public function initFetch(bool $initFetch = true): Chart
    {
        return $this->set('initFetch', $initFetch);
    }

    /**
     * 每次更新是完全覆盖配置项还是追加？
     * @default false
     * @param bool $replaceChartOption
     * @return Chart
     */
    public function replaceChartOption(bool $replaceChartOption = true): Chart
    {
        return $this->set('replaceChartOption', $replaceChartOption);
    }

    /**
     * 加载百度地图
     * @param bool $loadBaiduMap
     * @return Chart
     */
    public function loadBaiduMap(bool $loadBaiduMap = true): Chart
    {
        return $this->set('loadBaiduMap', $loadBaiduMap);
    }
}