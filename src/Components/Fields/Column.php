<?php
namespace Edith\Admin\Components\Fields;

use Edith\Admin\Components\BaseRenderer;
use Illuminate\Support\Collection;

/**
 * Antd Columns 通用列
 * @method $this key(string $key)                                      确定这个列的唯一值,一般用于 dataIndex 重复的情况
 * @method $this dataIndex(string $dataIndex)                          与实体映射的 key，数组会被转化 [a,b] => Entity.a.b
 * @method $this title(string $title)                                  标题的内容，在form中是label
 * @method $this tooltip(string $tooltip)                              会在 title 旁边展示一个 icon，鼠标浮动之后展示
 * @method $this valueType(string $valueType)                          值的类型,会生成不同的渲染器
 * @method $this valueEnum(array $valueEnum)                           值的枚举，会自动转化把值当成 key 来取出要显示的内容
 * @method $this request(string $request)                              传递给 Form.Item 的配置
 * @method $this initialValue($initialValue)                           查询表单/表单项初始值
 * @method $this width($width)                                         设定 Field 宽度
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn
 */
class Column extends BaseRenderer
{
    /**
     * 表单的 props
     * @var Collection
     */
    protected Collection $fieldProps;

    /**
     * 透传给 Form.Item 的配置
     * @var Collection
     */
    protected Collection $formItemProps;

    /**
     * construct Column
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        !is_null($dataIndex) && $this->set('dataIndex', $dataIndex);
        $this->fieldProps = new Collection();
        $this->formItemProps = new Collection();
        $this->set('key', $dataIndex ?: uniqid('column'));
        if (!is_null($title)) {
            $this->set('title', $title);
            $this->fieldProps->put('placeholder', "请输入{$title}");
        }
        $this->valueType('text');
    }

    /**
     * 是否支持复制
     * @param bool $copyable
     * @return Column
     */
    public function copyable(bool $copyable = true): Column
    {
        return $this->set('copyable', $copyable);
    }

    /**
     * 是否自动缩略
     * @param array|bool $ellipsis boolean | {showTitle?: boolean}
     * @return Column
     */
    public function ellipsis($ellipsis = true): Column
    {
        return $this->set('ellipsis', $ellipsis);
    }

    /**
     * 在编辑表格中是否可编辑的，函数的参数和 table 的 render 一样
     * @param bool $editable false | (text: any, record: T,index: number) => boolean
     * @default true
     * @return Column
     */
    public function editable(bool $editable = true): Column
    {
        return $this->set('editable', $editable);
    }

    /**
     * 表单隐藏项
     * @param bool $hidden
     * @return Column
     */
    public function hidden(bool $hidden = true): Column
    {
        return $this->set('formItemProps', $this->formItemProps->put('hidden', $hidden));
    }

    /**
     * 在 descriptions 中隐藏
     * @param bool $hideInDescriptions
     * @return Column
     */
    public function hideInDescriptions(bool $hideInDescriptions = true): Column
    {
        return $this->set('hideInDescriptions', $hideInDescriptions);
    }

    /**
     * 在查询表单中不展示此项
     * @param bool $hideInSearch
     * @return Column
     */
    public function hideInSearch(bool $hideInSearch = true): Column
    {
        return $this->set('hideInSearch', $hideInSearch);
    }

    /**
     * 在 Table 中不展示此列
     * @param bool $hideInTable
     * @return Column
     */
    public function hideInTable(bool $hideInTable = true): Column
    {
        return $this->set('hideInTable', $hideInTable);
    }

    /**
     * 在 Form 中不展示此列
     * @param bool $hideInForm
     * @return Column
     */
    public function hideInForm(bool $hideInForm): Column
    {
        return $this->set('hideInForm', $hideInForm);
    }

    /**
     * 设置表单必填项
     * @param bool $required
     * @return Column
     */
    public function required(bool $required = true): Column
    {
        return $this->formItemProp('required', $required);
    }

    /**
     * 表单项帮助提示
     * @param string $help
     * @return Column
     */
    public function help(string $help): Column
    {
        return $this->formItemProp('help', $help);
    }

    /**
     * 表单项帮助提示
     * @param string $content
     * @return Column
     */
    public function extra(string $content): Column
    {
        return $this->formItemProp('extra', $content);
    }

    /**
     * 表单的 props，会透传给表单项,如果渲染出来是 Input,就支持 input 的所有 props，同理如果是 select，也支持 select 的所有 props。也支持方法传入
     * @param string $field
     * @param string|bool|array|object|numeric $props
     * @return Column
     */
    public function fieldProp(string $field, $props): Column
    {
        return $this->set('fieldProps', $this->fieldProps->put($field, $props));
    }

    /**
     * 传递给 Form.Item 的配置
     * @param string $field
     * @param array|string|bool|numeric|object  $formItemProps
     * @return Column
     */
    public function formItemProp(string $field, $formItemProps): Column
    {
        return $this->set('formItemProps', $this->formItemProps->put($field, $formItemProps));
    }
}