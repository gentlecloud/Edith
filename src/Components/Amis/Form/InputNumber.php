<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis InputNumber 数字输入框
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-number
 * @method $this min(int $min)                         最小值
 * @method $this max(int $max)                         最大值
 * @method $this step(int $step)                       步长
 * @method $this precision(int $precision)             精度，即小数点后几位
 * @method $this prefix(string $prefix)                前缀
 * @method $this suffix(string $suffix)                后缀
 * @method $this resetValue(string $resetValue)        清空输入内容时，组件值将设置为resetValue
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputNumber extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-number';

    /**
     * @param string $type native-number | input-number
     * @return InputNumber
     */
    public function type(string $type): InputNumber
    {
        return $this->set('type', $type);
    }

    /**
     * 是否显示上下点击按钮
     * @param bool $showSteps
     * @return InputNumber
     */
    public function showSteps(bool $showSteps = true): InputNumber
    {
        return $this->set('showSteps', $showSteps);
    }

    /**
     * 千分分隔
     * @param bool $kilobitSeparator
     * @return InputNumber
     */
    public function kilobitSeparator(bool $kilobitSeparator = true): InputNumber
    {
        return $this->set('kilobitSeparator', $kilobitSeparator);
    }

    /**
     * 键盘事件（方向上下）
     * @param bool $keyboard
     * @return InputNumber
     */
    public function keyboard(bool $keyboard = true): InputNumber
    {
        return $this->set('keyboard', $keyboard);
    }

    /**
     * 是否使用大数
     * @param bool $big
     * @return InputNumber
     */
    public function big(bool $big = true): InputNumber
    {
        return $this->set('big', $big);
    }

    /**
     * 内容为空时从数据域中删除该表单项对应的值
     * @param bool $clearValueOnEmpty
     * @return InputNumber
     */
    public function clearValueOnEmpty(bool $clearValueOnEmpty = true): InputNumber
    {
        return $this->set('clearValueOnEmpty', $clearValueOnEmpty);
    }

    /**
     * 样式类型
     * @param string $displayMode enhance 加强版输入框
     * @return InputNumber
     * @throws RendererException
     */
    public function displayMode(string $displayMode = 'enhance'): InputNumber
    {
        if ($this->type != 'input-number') {
            throw new RendererException('Enhance display mode only support Input-Number');
        }
        return $this->set('displayMode', $displayMode);
    }
}