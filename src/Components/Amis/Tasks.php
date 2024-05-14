<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Tasks 任务操作集合
 * 任务操作集合，类似于 orp 上线。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/tasks
 * @method $this tableClassName(string $tableClassName)                   table Dom 的类名
 * @method $this items(array $items)                                      任务列表
 * @method $this checkApi($checkApi)                                      返回任务列表，返回的数据请参考 items。
 * @method $this submitApi($submitApi)                                    提交任务使用的 API
 * @method $this reSubmitApi($reSubmitApi)                                如果任务失败，且可以重试，提交的时候会使用此 API
 * @method $this interval(int $interval)                                  当有任务进行中，会每隔一段时间再次检测，而时间间隔就是通过此项配置，默认 3s。 单位毫秒，默认： 3000
 * @method $this taskNameLabel(string $taskNameLabel)                     任务名称列说明, 默认： 任务名称
 * @method $this operationLabel(string $operationLabel)                   操作列说明, 默认： 操作
 * @method $this statusLabel(string $statusLabel)                         状态列说明, 默认： 状态
 * @method $this remarkLabel(string $remarkLabel)                         备注列说明, 默认： 备注
 * @method $this btnText(string $btnText)                                 操作按钮文字, 默认： 上线
 * @method $this retryBtnText(string $retryBtnText)                       重试操作按钮文字, 默认： 重试
 * @method $this btnClassName(string $btnClassName)                       配置容器按钮 className, 默认：btn-sm btn-default
 * @method $this retryBtnClassName(string $retryBtnClassName)             配置容器重试按钮 className, 默认： btn-sm btn-danger
 * @method $this statusLabelMap(array $statusLabelMap)                    状态显示对应的类名配置 默认： ["label-warning", "label-info", "label-success", "label-danger", "label-default", "label-danger"]
 * @method $this statusTextMap(array $statusTextMap)                      状态显示对应的文字显示配置 默认： ["未开始", "就绪", "进行中", "出错", "已完成", "出错"]
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Tasks extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'tasks';
}