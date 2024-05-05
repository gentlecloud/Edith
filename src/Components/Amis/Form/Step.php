<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Wizard 向导步骤
 * 参考文档： https://baidu.github.io/amis/zh-CN/components/wizard
 * @method $this title(string $title)                               步骤标题
 * @method $this mode(string $mode)                                 展示默认，跟 Form 中的模式一样，选择： normal、horizontal或者inline。
 * @method $this horizontal(object $horizontal)                     当为水平模式时，用来控制左右占比  {label: "左边 label 的宽度占比", right: "右边控制器的宽度占比", offset: "当没有设置 label 时，右边控制器的偏移量"}
 * @method $this api(string $api)                                   当前步骤保存接口，可以不配置。
 * @method $this initApi(string $initApi)                           当前步骤数据初始化接口。
 * @method $this initFetch(bool $initFetch)                         当前步骤数据初始化接口是否初始拉取。
 * @method $this initFetchOn(string $initFetchOn)                   当前步骤数据初始化接口是否初始拉取，用表达式来决定。
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Step extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'step';
}