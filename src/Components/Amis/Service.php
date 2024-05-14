<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Service 功能型容器
 * amis 中部分组件，作为展示组件，自身没有使用接口初始化数据域的能力，例如：Table、Cards、List等，他们需要使用某些配置项，例如source，通过数据映射功能，在当前的 数据链 中获取数据，并进行数据展示。
 * 参考文档：   https://baidu.github.io/amis/zh-CN/components/service
 * @method $this api($api)                                   初始化数据域接口地址
 * @method $this ws(string $ws)                              WebScocket 地址
 * @method $this dataProvider($dataProvider)                 数据获取函数 string | Record<"inited" | "onApiFetched" | "onSchemaApiFetched" | "onWsFetched", string>
 * @method $this schemaApi($schemaApi)                       用来获取远程 Schema 接口地址
 * @method $this messages(object $messages)                  消息提示覆写，默认消息读取的是接口返回的 toast 提示文字，但是在此可以覆写它。
 * @method $this interval(int $interval)                     轮询时间间隔，单位 ms(最低 1000)
 * @method $this stopAutoRefreshWhen($stopAutoRefreshWhen)   配置停止轮询的条件 string  表达式
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Service extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'service';

    /**
     * 是否默认拉取
     * @default true
     * @param bool $initFetch
     * @return Service
     */
    public function initFetch(bool $initFetch = true): Service
    {
        return $this->set('initFetch', $initFetch);
    }

    /**
     * 是否默认拉取 Schema
     * @param bool $initFetchSchema
     * @return Service
     */
    public function initFetchSchema(bool $initFetchSchema = true): Service
    {
        return $this->set('initFetchSchema', $initFetchSchema);
    }

    /**
     * 配置轮询时是否显示加载动画
     * @default false
     * @param bool $silentPolling
     * @return Service
     */
    public function silentPolling(bool $silentPolling = true): Service
    {
        return $this->set('silentPolling', $silentPolling);
    }
}