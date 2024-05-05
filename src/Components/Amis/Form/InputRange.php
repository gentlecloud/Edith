<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis InputRange 滑块
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-range
 * @method $this min(int $min)                     最小值 默认 0
 * @method $this max(int $max)                     最小值 默认 100
 * @method $this step(int $step)                   步长 默认 1
 * @method $this parts($parts)                     分割的块数 主持数组传入分块的节点 number or number[] 默认 1
 * @method $this marks($marks)                     刻度标记{ [number | string]: ReactNode } or { [number | string]: { style: CSSProperties, label: ReactNode } }
 * @method $this tipFormatter($tipFormatter)       控制滑块标签显隐函数前置条件：tooltipVisible 不为 false 时有效
 * @method $this delimiter(string $delimiter)      分隔符 默认： ','
 * @method $this unit(string $unit)                单位
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputRange extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-range';

    /**
     * 是否显示步长
     * @default false
     * @param bool $showSteps
     * @return InputRange
     */
    public function showSteps(bool $showSteps = true): InputRange
    {
        return $this->set('showSteps', $showSteps);
    }

    /**
     * 是否显示滑块标签
     * @default false
     * @param bool $tooltipVisible
     * @return InputRange
     */
    public function tooltipVisible(bool $tooltipVisible = true): InputRange
    {
        return $this->set('tooltipVisible', $tooltipVisible);
    }

    /**
     * 滑块标签的位置，默认auto，方向自适应
     * 前置条件：tooltipVisible 不为 false 时有效
     * @default top
     * @param string $tooltipPlacement 'auto', 'bottom', 'left', 'right'
     * @return InputRange
     * @throws RendererException
     */
    public function tooltipPlacement(string $tooltipPlacement): InputRange
    {
        if (!in_array($tooltipPlacement, ['auto', 'bottom', 'left', 'right'])) {
            throw new RendererException("Tooltip placement only supports auto , bottom , left, right");
        }
        return $this->set('tooltipPlacement', $tooltipPlacement);
    }

    /**
     * 支持选择范围
     * @default false
     * @param bool $multiple
     * @return InputRange
     */
    public function multiple(bool $multiple = true): InputRange
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 默认为 true，选择的 value 会通过 delimiter 连接起来，否则直接将以{min: 1, max: 100}的形式提交
     * 前置条件：开启multiple时有效
     * @default true
     * @param bool $joinValues
     * @return InputRange
     */
    public function joinValues(bool $joinValues = true): InputRange
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 是否可清除
     * 前置条件：开启showInput时有效
     * @default false
     * @param bool $clearable
     * @return InputRange
     */
    public function clearable(bool $clearable = true): InputRange
    {
        return $this->set('clearable', $clearable);
    }

    /**
     * 是否显示输入框
     * @default false
     * @param bool $showInput
     * @return InputRange
     */
    public function showInput(bool $showInput = true): InputRange
    {
        return $this->set('showInput', $showInput);
    }
}