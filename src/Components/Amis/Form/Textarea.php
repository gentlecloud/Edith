<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form 多行文本输入框
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/form/textarea
 * @method $this minRows(int $minRows)                              最小行数
 * @method $this maxRows(int $maxRows)                              最大行数
 * @method $this maxLength(int $maxLength)                          限制最大字数
 * @method $this resetValue(string $resetValue)                     清除后设置此配置项给定的值。
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Textarea extends FormItem
{
    /**
     * Amis FormItem 渲染类型
     * @var string
     */
    protected string $type = 'textarea';

    /**
     * 是否去除首尾空白文本
     * @default true
     * @param bool $trimContents
     * @return Textarea
     */
    public function trimContents(bool $trimContents = true): Textarea
    {
        return $this->set('trimContents', $trimContents);
    }

    /**
     * 是否只读
     * @default false
     * @param bool $readOnly
     * @return Textarea
     */
    public function readOnly(bool $readOnly = true): Textarea
    {
        return $this->set('readOnly', $readOnly);
    }

    /**
     * 是否显示计数器
     * @default false
     * @param bool $showCounter
     * @return Textarea
     */
    public function showCounter(bool $showCounter = true): Textarea
    {
        return $this->set('showCounter', $showCounter);
    }

    /**
     * 是否可清除
     * @default false
     * @param bool $clearable
     * @return Textarea
     */
    public function clearable(bool $clearable = true): Textarea
    {
        return $this->set('clearable', $clearable);
    }
}