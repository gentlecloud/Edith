<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Remark 标记
 * 用于展示提示文本，和表单项中的 remark 属性类型。
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/remark
 * @method $this content(string $content)                             提示文本
 * @method $this placement(string $placement)                         弹出位置
 * @method $this trigger(array $trigger)                              触发条件  默认： ['hover', 'focus']
 * @method $this icon(string $icon)                                   图标  默认： fa fa-question-circle
 * @method $this shape(string $shape)                                 图标形状  'circle' | 'square'
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Remark extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'remark';
}