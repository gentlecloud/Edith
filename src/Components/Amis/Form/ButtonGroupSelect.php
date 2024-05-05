<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Exceptions\RendererException;

/***
 * Amis Form Button-Group-Select 按钮点选
 * 参考文档:  https://aisuda.bce.baidu.com/amis/zh-CN/components/form/button-group-select
 * @method $this options(array $options)                             选项组
 * @method $this source($source)                                     动态选项组 string | API
 * @method $this labelField(string $labelField)                      选项标签字段 默认： "label"
 * @method $this valueField(string $valueField)                      选项值字段 默认： "value"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class ButtonGroupSelect extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'button-group-select';

    /**
     * 按钮样式
     * @default default
     * @param string $btnLevel 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'
     * @return ButtonGroupSelect
     * @throws RendererException
     */
    public function btnLevel(string $btnLevel): ButtonGroupSelect
    {
        if (!in_array($btnLevel, ['link', 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'default'])) {
            throw new RendererException("Btn level only supports 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'");
        }
        return $this->set('btnLevel', $btnLevel);
    }

    /**
     * 选中按钮样式
     * @default default
     * @param string $btnActiveLevel 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'
     * @return ButtonGroupSelect
     * @throws RendererException
     */
    public function btnActiveLevel(string $btnActiveLevel): ButtonGroupSelect
    {
        if (!in_array($btnActiveLevel, ['link', 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'default'])) {
            throw new RendererException("Btn level only supports 'link' | 'primary' | 'secondary' | 'info'|'success' | 'warning' | 'danger' | 'light'| 'dark' | 'default'");
        }
        return $this->set('btnActiveLevel', $btnActiveLevel);
    }

    /**
     * 是否使用垂直模式
     * @default false
     * @param bool $vertical
     * @return ButtonGroupSelect
     */
    public function vertical(bool $vertical = true): ButtonGroupSelect
    {
        return $this->set('vertical', $vertical);
    }

    /**
     * 是否使用平铺模式
     * @default false
     * @param bool $tiled
     * @return ButtonGroupSelect
     */
    public function tiled(bool $tiled = true): ButtonGroupSelect
    {
        return $this->set('tiled', $tiled);
    }

    /**
     * 多选
     * @default false
     * @param bool $multiple
     * @return ButtonGroupSelect
     */
    public function multiple(bool $multiple = true): ButtonGroupSelect
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return ButtonGroupSelect
     */
    public function joinValues(bool $joinValues = true): ButtonGroupSelect
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return ButtonGroupSelect
     */
    public function extractValue(bool $extractValue = true): ButtonGroupSelect
    {
        return $this->set('extractValue', $extractValue);
    }
}