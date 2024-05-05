<?php
namespace Gentle\Edith\Components\Amis\Form;

/**
 * Amis Form Formula 公式
 * 可以设置公式，将公式结果设置到指定表单项上。
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/formula
 * @method $this formula($formula)                          应用的公式
 * @method $this condition($condition)                      公式作用条件
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Formula extends FormItem
{
    /**
     * @var string 
     */
    protected string $type = 'formula';

    /**
     * 初始化时是否设置
     * @default true
     * @param bool $initSet
     * @return Formula
     */
    public function initSet(bool $initSet = true): Formula
    {
        return $this->set('initSet', $initSet);
    }

    /**
     * 观察公式结果，如果计算结果有变化，则自动应用到变量上
     * @default true
     * @param bool $autoSet
     * @return Formula
     */
    public function autoSet(bool $autoSet = true): Formula
    {
        return $this->set('autoSet', $autoSet);
    }

    /**
     * 定义个名字，当某个按钮的目标指定为此值后，会触发一次公式应用。这个机制可以在 autoSet 为 false 时用来手动触发
     * @default true
     * @param bool $id
     * @return Formula
     */
    public function id(bool $id = true): Formula
    {
        return $this->set('id', $id);
    }
}