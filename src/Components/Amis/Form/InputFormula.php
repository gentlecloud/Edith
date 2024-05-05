<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Exceptions\RendererException;

/***
 * Amis Form InputFormula 公式编辑器
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-formula
 * @method $this header(string $header)                           编辑器 header 标题，如果不设置，默认使用表单项label字段
 * @method $this variables(array $variables)                      可用变量 {label: string; value: string; children?: any[]; tag?: string}[]
 * @method $this variableMode(string $variableMode)               可配置成 tabs 或者 tree 默认为列表，支持分组。 默认： "list"
 * @method $this functions(array $functions)                      可以不设置，默认就是 amis-formula 里面定义的函数，如果扩充了新的函数则需要指定 Object[]
 * @method $this icon(string $icon)                               按钮图标，例如fa fa-list
 * @method $this btnLabel(string $btnLabel)                       按钮文本，inputMode为button时生效
 * @method $this placeholder(string $placeholder)                 输入框占位符 默认: 暂无数据
 * @method $this variableClassName(string $variableClassName)     变量面板 CSS 样式类名
 * @method $this functionClassName(string $functionClassName)     函数面板 CSS 样式类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class InputFormula extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'input-formula';

    /**
     * 表达式模式 或者 模板模式，模板模式则需要将表达式写在 ${ 和 } 中间。
     * @default true
     * @param bool $evalMode
     * @return InputFormula
     */
    public function evalMode(bool $evalMode = true): InputFormula
    {
        return $this->set('evalMode', $evalMode);
    }

    /**
     * 控件的展示模式
     * @param string $inputMode 'button' | 'input-button' | 'input-group'
     * @return InputFormula
     * @throws RendererException
     */
    public function inputMode(string $inputMode): InputFormula
    {
        if (!in_array($inputMode, ['button', 'input-button', 'input-group'])) {
            throw new RendererException("Input mode only supports 'button' | 'input-button' | 'input-group'");
        }
        return $this->set('inputMode', $inputMode);
    }

    /**
     * 按钮样式
     * @default default
     * @param string $level 'info' | 'success' | 'warning' | 'danger' | 'link' | 'primary' | 'dark' | 'light'
     * @return InputFormula
     * @throws RendererException
     */
    public function level(string $level): InputFormula
    {
        if (!in_array($level, ['info', 'success', 'warning', 'danger', 'link', 'primary', 'dark', 'light'])) {
            throw new RendererException("Level only supports 'info' | 'success' | 'warning' | 'danger' | 'link' | 'primary' | 'dark' | 'light'");
        }
        return $this->set('level', $level);
    }

    /**
     * 输入框是否可输入
     * @param bool $allowInput
     * @return InputFormula
     */
    public function allowInput(bool $allowInput = true): InputFormula
    {
        return $this->set('allowInput', $allowInput);
    }

    /**
     * 按钮大小
     * @param string $btnSize
     * @return InputFormula
     * @throws RendererException
     */
    public function btnSize(string $btnSize): InputFormula
    {
        if (!in_array($btnSize, ['xs', 'sm', 'md', 'lg'])) {
            throw new RendererException("Btn size only supports 'xs' | 'sm' | 'md' | 'lg'");
        }
        return $this->set('btnSize', $btnSize);
    }

    /**
     * 输入框边框模式
     * @param string $borderMode 'full' | 'half' | 'none'
     * @return InputFormula
     * @throws RendererException
     */
    public function borderMode(string $borderMode): InputFormula
    {
        if (!in_array($borderMode, ['full', 'half', 'none'])) {
            throw new RendererException("Border mode only supports 'full' | 'half' | 'none'");
        }
        return $this->set('borderMode', $borderMode);
    }
}