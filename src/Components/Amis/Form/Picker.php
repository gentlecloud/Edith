<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Form Picker 列表选择器
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/picker
 * @method $this options(array $options)                               选项组
 * @method $this source($source)                                       动态选项组 string | API
 * @method $this delimiter(string $delimiter)                          拼接符
 * @method $this labelField(string $labelField)                        选项标签字段 默认： label
 * @method $this valueField(string $valueField)                        选项值字段 默认： value
 * @method $this pickerSchema($pickerSchema)                           即用 List 类型的渲染，来展示列表信息。更多配置参考 CRUD {mode: 'list', listItem: {title: '${label}'}}
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Picker extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'picker';

    /**
     * 是否为多选
     * @param bool $multiple
     * @return Picker
     */
    public function multiple(bool $multiple = true): Picker
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 拼接值
     * @param bool $joinValues
     * @return Picker
     */
    public function joinValues(bool $joinValues = true): Picker
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @param bool $extractValue
     * @return Picker
     */
    public function extractValue(bool $extractValue = true): Picker
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 设置 dialog 或者 drawer，用来配置弹出方式
     * @param string $modalMode drawer | dialog
     * @return Picker
     * @throws RendererException
     */
    public function modalMode(string $modalMode): Picker
    {
        if (!in_array($modalMode, ['dialog', 'drawer'])) {
            throw new RendererException("Picker modal mode only supports dialog or drawer");
        }
        return $this->set('modalMode', $modalMode);
    }

    /**
     * 是否使用内嵌模式
     * @default false
     * @param bool $embed
     * @return Picker
     */
    public function embed(bool $embed = true): Picker
    {
        return $this->set('embed', $embed);
    }
}