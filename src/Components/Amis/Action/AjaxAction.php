<?php
namespace Gentle\Edith\Components\Amis\Action;

/**
 * Amis Ajax API请求
 * 参考：https://aisuda.bce.baidu.com/amis/zh-CN/docs/types/api
 * @method $this api($api)                                     Ajax请求接口 简单请求方式，不支持携带表单等内容
 * @method $this method(string $method)                               请求方式  支持：get、post、put、delete
 * @method $this url(string $url)                                     请求地址 复杂配置，支持携带表单
 * @method $this data($data)                                          请求数据 对象或字符串	支持数据映射
 * @method $this dataType(string $dataType)                           默认为 json 可以配置成 form 或者 form-data。当 data 中包含文件时，自动会采用 form-data（multipart/form-data） 格式。当配置为 form 时为 application/x-www-form-urlencoded 格式。
 * @method $this qsOptions($qsOptions)                                当 dataType 为 form 或者 form-data 的时候有用。具体参数请参考这里，默认设置为: { arrayFormat: 'indices', encodeValuesOnly: true }
 * @method $this headers(array $headers)                              请求头
 * @method $this sendOn($sendOn)                                      请求条件
 * @method $this cache(int $cache)                                    接口缓存时间
 * @method $this requestAdaptor($requestAdaptor)                      发送适配器
 * @method $this adaptor($adaptor)                                    接收适配器 如果接口返回不符合要求，可以通过配置一个适配器来处理成 amis 需要的。同样支持 Function 或者 字符串函数体格式
 * @method $this replaceData(bool $replaceData)                       替换当前数据  	返回的数据是否替换掉当前的数据，默认为 false，即：追加，设置成 true 就是完全替换。
 * @method $this responseType(string $responseType)                   如果是下载需要设置为 'blob'
 * @method $this autoRefresh(bool $autoRefresh)                       是否自动刷新 配置是否需要自动刷新接口。
 * @method $this responseData(array $responseData)                    对返回结果做个映射
 * @method $this trackExpression(string $trackExpression)             配置跟踪变量表达式
 * @method $this messages(array $messages)                            配置接口请求的提示信息，messages.success 表示请求成功提示信息、messages.failed 表示请求失败提示信息
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class AjaxAction extends Action
{
    /**
     * @var string
     */
    protected string $actionType = 'ajax';

    /**
     * construct AjaxAction
     * @param string|array|null $api
     */
    public function __construct($api = null)
    {
        parent::__construct();
        if (!is_null($api)) {
            $this->set('api', $api);
        }
    }
}