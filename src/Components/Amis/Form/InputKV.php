<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputKV 键值对
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-kv
 * @method $this keyPlaceholder(string $keyPlaceholder)                       key 的提示信息的
 * @method $this valuePlaceholder(string $valuePlaceholder)                   value 的提示信息的
 * @method $this defaultValue($defaultValue)                                  默认值
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputKV extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-kv';

    /**
     * 是否可拖拽排序
     * @default true
     * @param bool $draggable
     * @return InputKV
     */
    public function draggable(bool $draggable = true): InputKV
    {
        return $this->set('draggable', $draggable);
    }
}