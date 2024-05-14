<?php
namespace Edith\Admin\Components\Amis\Form;

/**
 * Amis Form Select 下拉框
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/form/select
 * @method $this options(array $options)                          选项组 Array<object>或Array<string>
 * @method $this source($source)                                  动态选项组  API 或 数据映射
 * @method $this autoComplete($autoComplete)                      自动提示补全 string | API
 * @method $this delimiter(string $delimiter)                     拼接符
 * @method $this labelField(string $labelField)                   选项标签字段 默认： 'label'
 * @method $this valueField(string $valueField)                   选项值字段 默认： 'value'
 * @method $this checkAllLabel(string $checkAllLabel)             全选的文字 默认： '全选'
 * @method $this createBtnLabel(string $createBtnLabel)           新增选项 默认： '新增选项'
 * @method $this addControls(array $addControls)                  自定义新增表单项  Array<表单项>
 * @method $this addApi($addApi)                                  配置新增选项接口 string | API
 * @method $this editControls(array $editControls)                自定义编辑表单项  Array<表单项>
 * @method $this editApi($editApi)                                配置编辑选项接口 string | API
 * @method $this deleteApi($deleteApi)                            配置删除选项接口 string | API
 * @method $this menuTpl(string $menuTpl)                         支持配置自定义菜单
 * @method $this mobileClassName(string $mobileClassName)         移动端浮层类名
 * @method $this selectMode(string $selectMode)                   可选：group、table、tree、chained、associated。分别为：列表形式、表格形式、树形选择形式、级联选择形式，关联选择形式（与级联选择的区别在于，级联是无限极，而关联只有一级，关联左边可以是个 tree）。
 * @method $this searchResultMode(string $searchResultMode)       如果不设置将采用 selectMode 的值，可以单独配置，参考 selectMode，决定搜索结果的展示形式。
 * @method $this columns(array $columns)                          当展示形式为 table 可以用来配置展示哪些列，跟 table 中的 columns 配置相似，只是只有展示功能。
 * @method $this leftOptions(array $leftOptions)                  当展示形式为 associated 时用来配置左边的选项集。
 * @method $this leftMode(string $leftMode)                       当展示形式为 associated 时用来配置左边的选择形式，支持 list 或者 tree。默认为 list。
 * @method $this rightMode(string $rightMode)                     当展示形式为 associated 时用来配置右边的选择形式，可选：list、table、tree、chained。
 * @method $this maxTagCount(int $maxTagCount)                    标签的最大展示数量，超出数量后以收纳浮层的方式展示，仅在多选模式开启后生效
 * @method $this overflowTagPopover($overflowTagPopover)          收纳浮层的配置属性，详细配置参考Tooltip 默认： {"placement": "top", "trigger": "hover", "showArrow": false, "offset": [0, -10]}
 * @method $this optionClassName(string $optionClassName)         选项 CSS 类名
 * @method $this popOverContainerSelector(string $value)          弹层挂载位置选择器，会通过querySelector获取
 * @method $this overlay(array $overlay)                          弹层宽度与对齐方式 { width: string | number, align: "left" | "center" | "right" }
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Select extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'select';

    /**
     * 拼接值
     * @default true
     * @param bool $joinValues
     * @return Select
     */
    public function joinValues(bool $joinValues = true): Select
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 提取值
     * @default false
     * @param bool $extractValue
     * @return Select
     */
    public function extractValue(bool $extractValue = true): Select
    {
        return $this->set('extractValue', $extractValue);
    }

    /**
     * 是否支持全选
     * @default false
     * @param bool $checkAll
     * @return Select
     */
    public function checkAll(bool $checkAll = true): Select
    {
        return $this->set('checkAll', $checkAll);
    }

    /**
     * 有检索时只全选检索命中的项
     * @default false
     * @param bool $checkAllBySearch
     * @return Select
     */
    public function checkAllBySearch(bool $checkAllBySearch = true): Select
    {
        return $this->set('checkAllBySearch', $checkAllBySearch);
    }

    /**
     * 默认是否全选
     * @default false
     * @param bool $defaultCheckAll
     * @return Select
     */
    public function defaultCheckAll(bool $defaultCheckAll = true): Select
    {
        return $this->set('defaultCheckAll', $defaultCheckAll);
    }

    /**
     * 新增选项
     * @default false
     * @param bool $creatable
     * @return Select
     */
    public function creatable(bool $creatable = true): Select
    {
        return $this->set('creatable', $creatable);
    }

    /**
     * 多选
     * @default false
     * @param bool $multiple
     * @return Select
     */
    public function multiple(bool $multiple = true): Select
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 检索
     * @default false
     * @param bool $searchable
     * @return Select
     */
    public function searchable(bool $searchable = true): Select
    {
        return $this->set('searchable', $searchable);
    }

    /**
     * 编辑选项
     * @default false
     * @param bool $editable
     * @return Select
     */
    public function editable(bool $editable = true): Select
    {
        return $this->set('editable', $editable);
    }

    /**
     * 删除选项
     * @default false
     * @param bool $removable
     * @return Select
     */
    public function removable(bool $removable = true): Select
    {
        return $this->set('removable', $removable);
    }

    /**
     * 单选模式下是否支持清空
     * @param bool $clearable
     * @return Select
     */
    public function clearable(bool $clearable = true): Select
    {
        return $this->set('clearable', $clearable);
    }

    /**
     * 隐藏已选选项
     * @default false
     * @param bool $hideSelected
     * @return Select
     */
    public function hideSelected(bool $hideSelected = true): Select
    {
        return $this->set('hideSelected', $hideSelected);
    }
}