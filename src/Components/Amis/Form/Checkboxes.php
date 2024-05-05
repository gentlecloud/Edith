<?php
namespace Gentle\Edith\Components\Amis\Form;

use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis Checkboxes 复选框
 * 用于实现多选。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/checkboxes
 * @method $this options(array $options)                                选项组
 * @method $this source($source)                                        动态选项组 string | API
 * @method $this delimiter(string $delimiter)                           拼接符 默认： ','
 * @method $this labelField(string $labelField)                         选项标签字段 默认： 'label'
 * @method $this valueField(string $valueField)                         选项值字段 默认： 'value'
 * @method $this columnsCount(int $columnsCount)                        选项按几列显示，默认为一列 默认：1
 * @method $this menuTpl(string $menuTpl)                               支持自定义选项渲染
 * @method $this createBtnLabel(string $createBtnLabel)                 新增选项 默认： "新增选项"
 * @method $this addControls(array $addControls)                        自定义新增表单项 Array<表单项>
 * @method $this addApi($addApi)                                        配置新增选项接口
 * @method $this editControls(array $editControls)                      自定义编辑表单项 Array<表单项>
 * @method $this editApi($editApi)                                      配置编辑选项接口
 * @method $this deleteApi($deleteApi)                                  配置删除选项接口
 * @method $this itemClassName(string $itemClassName)                   选项样式类名
 * @method $this labelClassName(string $labelClassName)                 选项标签样式类名
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Checkboxes extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string 
     */
    protected string $type = 'checkboxes';

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return Checkboxes
     */
    public function joinValues(bool $joinValues = true): Checkboxes
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return Checkboxes
     */
    public function extractValue(bool $extractValue = true): Checkboxes
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 是否支持全选
     * @default false
     * @param bool $checkAll
     * @return Checkboxes
     */
    public function checkAll(bool $checkAll = true): Checkboxes
    {
        return $this->set('checkAll', $checkAll);
    }

    /**
     * 是否显示为一行
     * @default true
     * @param bool $inline
     * @return Checkboxes
     */
    public function inline(bool $inline = true): Checkboxes
    {
        return $this->set('inline', $inline);
    }

    /***
     * 默认是否全选
     * @default false
     * @param bool $defaultCheckAll
     * @return Checkboxes
     */
    public function defaultCheckAll(bool $defaultCheckAll = true): Checkboxes
    {
        return $this->set('defaultCheckAll', $defaultCheckAll);
    }

    /**
     * 新增选项
     * @default false
     * @param bool $creatable
     * @return Checkboxes
     */
    public function creatable(bool $creatable = true): Checkboxes
    {
        return $this->set('creatable', $creatable);
    }

    /***
     * 编辑选项
     * @default false
     * @param bool $editable
     * @return Checkboxes
     */
    public function editable(bool $editable = true): Checkboxes
    {
        return $this->set('editable', $editable);
    }

    /***
     * 删除选项
     * @default false
     * @param bool $removable
     * @return Checkboxes
     */
    public function removable(bool $removable = true): Checkboxes
    {
        return $this->set('removable', $removable);
    }

    /**
     * 按钮模式
     * @default default
     * @param string $optionType
     * @return Checkboxes
     * @throws RendererException
     */
    public function optionType(string $optionType): Checkboxes
    {
        if (!in_array($optionType, ['default', 'button'])) {
            throw new RendererException("Option type only supports 'default' | 'button'");
        }
        return $this->set('optionType', $optionType);
    }
}