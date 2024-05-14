<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/***
 * Amis InputColor 颜色选择器
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/input-color
 * @method $this presetColors(array $presetColors)                        选择器底部的默认颜色，数组内为空则不显示默认颜色
 * @method $this resetValue(string $resetValue)                           清除后，表单项值调整成该值
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class InputColor extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string 
     */
    protected string $type = 'input-color';

    /**
     * @default hex
     * @param string $format 'hex', 'hls', 'rgb', 'rgba'
     * @return InputColor
     * @throws RendererException
     */
    public function format(string $format): InputColor
    {
        if (!in_array($format, ['hex', 'hls', 'rgb', 'rgba'])) {
            throw new RendererException("Format only supports 'hex'、'hls'、'rgb' or 'rgba'。");
        }
        return $this->set('format', $format);
    }

    /**
     * 为false时只能选择颜色，使用 presetColors 设定颜色选择范围
     * @default true
     * @param bool $allowCustomColor
     * @return InputColor
     */
    public function allowCustomColor(bool $allowCustomColor = true): InputColor
    {
        return $this->set('allowCustomColor', $allowCustomColor);
    }

    /**
     * 是否显示清除按钮
     * @param bool $clearable
     * @return InputColor
     */
    public function clearable(bool $clearable = true): InputColor
    {
        return $this->set('clearable', $clearable);
    }
}