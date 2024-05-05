<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Wizard 向导
 * 参考文档： https://baidu.github.io/amis/zh-CN/components/wizard
 * @method $this mode(string $mode)                               展示模式，选择：horizontal 或者 vertical  默认： horizontal
 * @method $this api(string $api)                                 最后一步保存的接口。
 * @method $this initApi(string $initApi)                         初始化数据接口
 * @method $this initFetch(boolean $initFetch)                    初始是否拉取数据。
 * @method $this initFetchOn($initFetchOn)                        初始是否拉取数据，通过表达式来配置
 * @method $this actionPrevLabel(string $actionPrevLabel)         上一步按钮文本 默认： 上一步
 * @method $this actionNextLabel(string $actionNextLabel)         下一步按钮文本 默认： 下一步
 * @method $this actionNextSaveLabel(string $actionNextSaveLabel) 保存并下一步按钮文本  默认： 保存并下一步
 * @method $this actionFinishLabel(string $actionFinishLabel)     完成按钮文本 默认： 完成
 * @method $this actionClassName(string $actionClassName)         按钮 CSS 类名  默认： btn-sm btn-default
 * @method $this reload(string $reload)                           操作完后刷新目标对象。请填写目标组件设置的 name 值，如果填写为 window 则让当前页面整体刷新。
 * @method $this redirect(string $redirect)                       操作完后跳转。
 * @method $this target($target)                                  可以把数据提交给别的组件而不是自己保存。请填写目标组件设置的 name 值，如果填写为 window 则把数据同步到地址栏上，同时依赖这些数据的组件会自动重新刷新。
 * @method $this steps(array $steps)                              数组，配置步骤信息
 * @method $this startStep(string $startStep)                     起始默认值，从第几步开始。可支持模版，但是只有在组件创建时渲染模版并设置当前步数，在之后组件被刷新时，当前 step 不会根据 startStep 改变
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Wizard extends AmisRenderer
{
    /**
     * Amis 渲染类型 指定为 Wizard 组件
     * @var string
     */
    protected string $type = 'wizard';
}