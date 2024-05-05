<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\BaseRenderer;

/**
 * Amis OnAction 操作
 * @method $this actionType(string $actionType)                              动作名称
 * @method $this args(array $args)                                           动作属性{key:value}，支持数据映射
 * @method $this data(array $data)                                           追加数据{key:value}，支持数据映射，如果是触发其他组件的动作，则该数据会传递给目标组件
 * @method $this dataMergeMode(string $dataMergeMode)                        当配置了 data 的时候，可以控制数据追加方式，支持合并(merge)和覆盖(override)两种模式
 * @method $this preventDefault($preventDefault)                             阻止事件默认行为，支持表达式
 * @method $this stopPropagation($stopPropagation)                           停止后续动作执行，支持表达式
 * @method $this expression($expression)                                     执行条件，不设置表示默认执行
 * @method $this outputVar(string $outputVar)                                输出数据变量名
 * @method $this redirect(?string $redirect)                                 操作成功后跳转链接
 * @method $this feedback($feedback)                                         操作成功后弹窗反馈
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class OnAction extends BaseRenderer
{
    /**
     * @var string
     */
    protected string $type = 'action';

    /**
     * 定义执行 Ajax 请求
     * @param array|null $api 基础 API 配置
     * @return OnAction
     */
    public function api(?array $api = null): OnAction
    {
        $this->set('actionType', 'ajax');
        return $this->set('OnAction', $api);
    }
}