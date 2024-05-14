<?php
namespace Edith\Admin\Components\Amis\Form;

use Edith\Admin\Exceptions\RendererException;

/**
 * Amis Form Combo 组合
 * 用于将多个表单项组合到一起，实现深层结构的数据编辑。比如想提交 user.name 这样的数据结构，有两种方法：一种是将表单项的 name 设置为user.name，另一种就是使用 combo。
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/form/combo
 * @method $this formClassName(string $formClassName)                               单组表单项的类名
 * @method $this items(array $items)                                                组合展示的表单项 Array<表单项>
 * @method $this scaffold(array $scaffold)                                          单组表单项初始值
 * @method $this minLength(int $minLength)                                          最少添加的条数，2.4.1 版本后支持变量
 * @method $this maxLength(int $maxLength)                                          最多添加的条数，2.4.1 版本后支持变量
 * @method $this delimiter(string $delimiter)                                       当扁平化开启并且 joinValues 为 true 时，用什么分隔符。
 * @method $this deleteApi($deleteApi)                                              如果配置了，则删除前会发送一个 api，请求成功才完成删除
 * @method $this deleteConfirmText(string $deleteConfirmText)                       当配置 deleteApi 才生效！删除时用来做用户确认 默认： "确认要删除？"
 * @method $this draggableTip(string $draggableTip)                                 可拖拽的提示文字
 * @method $this placeholder(string $placeholder)                                   没有成员时显示。
 * @method $this conditions(array $conditions)                                      数组的形式包含所有条件的渲染类型，单个数组内的test 为判断条件，数组内的items为符合该条件后渲染的schema
 * @method $this syncFields(array $syncFields)                                      配置同步字段。只有 strictMode 为 false 时有效。如果 Combo 层级比较深，底层的获取外层的数据可能不同步。但是给 combo 配置这个属性就能同步下来。输入格式：["os"] Array<string>
 * @method $this itemClassName(string $itemClassName)                               单组 CSS 类
 * @method $this itemsWrapperClassName(string $itemsWrapperClassName)               组合区域 CSS 类
 * @method $this deleteBtn($deleteBtn)                                              只有当removable为 true 时有效; 如果为string则为按钮的文本；如果为Button则根据配置渲染删除按钮。  string | Button
 * @method $this addBtn($addBtn)                                                    可新增自定义配置渲染新增按钮，在tabsMode: true下不生效。
 * @method $this addButtonClassName(string $addButtonClassName)                     新增按钮 CSS 类名
 * @method $this addButtonText(string $addButtonText)                               新增按钮文字 默认： "新增"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn/
 */
class Combo extends FormItem
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'combo';

    /**
     * 单组表单项是否显示边框
     * @default false
     * @param bool $noBorder
     * @return Combo
     */
    public function noBorder(bool $noBorder = true): Combo
    {
        return $this->set('noBorder', $noBorder);
    }

    /**
     * 是否多选
     * @default false
     * @param bool $multiple
     * @return Combo
     */
    public function multiple(bool $multiple = true): Combo
    {
        return $this->set('multiple', $multiple);
    }

    /**
     * 默认是横着展示一排，设置以后竖着展示
     * @default false
     * @param bool $multiLine
     * @return Combo
     */
    public function multiLine(bool $multiLine = true): Combo
    {
        return $this->set('multiLine', $multiLine);
    }

    /**
     * 是否将结果扁平化(去掉 name),只有当 items 的 length 为 1 且 multiple 为 true 的时候才有效。
     * @default false
     * @param bool $flat
     * @return Combo
     */
    public function flat(bool $flat = true): Combo
    {
        return $this->set('flat', $flat);
    }

    /**
     * 默认为 true 当扁平化开启的时候，是否用分隔符的形式发送给后端，否则采用 array 的方式。
     * @default true
     * @param bool $joinValues
     * @return Combo
     */
    public function joinValues(bool $joinValues = true): Combo
    {
        return $this->set('joinValues', $joinValues);
    }

    /**
     * 是否可新增
     * @default false
     * @param bool $addable
     * @return Combo
     */
    public function addable(bool $addable = true): Combo
    {
        return $this->set('addable', $addable);
    }

    /**
     * 在顶部添加
     * @default false
     * @param bool $addattop
     * @return Combo
     */
    public function addattop(bool $addattop = true): Combo
    {
        return $this->set('addattop', $addattop);
    }

    /**
     * 是否可删除
     * @default false
     * @param bool $removable
     * @return Combo
     */
    public function removable(bool $removable = true): Combo
    {
        return $this->set('removable', $removable);
    }

    /**
     * 否可以拖动排序, 需要注意的是当启用拖动排序的时候，会多一个$id 字段
     * @default false
     * @param bool $draggable
     * @return Combo
     */
    public function draggable(bool $draggable = true): Combo
    {
        return $this->set('draggable', $draggable);
    }

    /**
     * @default normal
     * @param string $subFormMode normal、horizontal、inline
     * @return Combo
     * @throws RendererException
     */
    public function subFormMode(string $subFormMode): Combo
    {
        if (!in_array($subFormMode, ['normal', 'horizontal', 'inline'])) {
            throw new RendererException("Sub form mode only supports normal、horizontal、inline");
        }
        return $this->set('subFormMode', $subFormMode);
    }

    /**
     * 指定是否可以自动获取上层的数据并映射到表单项上
     * @default false
     * @param bool $canAccessSuperData
     * @return Combo
     */
    public function canAccessSuperData(bool $canAccessSuperData = true): Combo
    {
        return $this->set('canAccessSuperData', $canAccessSuperData);
    }

    /**
     * 是否可切换条件，配合conditions使用
     * @default false
     * @param bool $typeSwitchable
     * @return Combo
     */
    public function typeSwitchable(bool $typeSwitchable = true): Combo
    {
        return $this->set('typeSwitchable', $typeSwitchable);
    }

    /**
     * 默认为严格模式，设置为 false 时，当其他表单项更新是，里面的表单项也可以及时获取，否则不会。
     * @default true
     * @param bool $strictMode
     * @return Combo
     */
    public function strictMode(bool $strictMode = true): Combo
    {
        return $this->set('strictMode', $strictMode);
    }

    /**
     * 允许为空，如果子表单项里面配置验证器，且又是单条模式。可以允许用户选择清空（不填）。
     * @default false
     * @param bool $nullable
     * @return Combo
     */
    public function nullable(bool $nullable = true): Combo
    {
        return $this->set('nullable', $nullable);
    }
}