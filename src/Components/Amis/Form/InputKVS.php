<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form InputKVS 键值对象
 * 这个组件的功能和 input-kv 类似，input-kv 的 value 值只支持一个对象，input-kvs 的最大不同就是 value 支持对象和数组，可以用来支持深层结构编辑
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-kvs
 * @method $this name(string $name)
 * @method $this addButtonText(string $addButtonText)
 * @method $this keyItem(array $keyItem)
 * @method $this valueItems(array $valueItems)
 */
class InputKVS extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-kvs';

    /**
     * @param bool $valueIsArray
     * @return InputKVS
     */
    public function valueIsArray(bool $valueIsArray = true): InputKVS
    {
        return $this->set('valueIsArray', $valueIsArray);
    }
}