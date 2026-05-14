<?php
namespace Edith\Admin\Components\Columns;

use Edith\Admin\Components\BaseRenderer;
use Edith\Admin\Components\Fields\BaseField;
use Edith\Admin\Components\Traits\Fields\FieldAttribute;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Antd Columns 通用列
 * @method $this dataIndex(string $dataIndex)                          与实体映射的 key，数组会被转化 [a,b] => Entity.a.b
 * @method $this title(string $title)                                  标题的内容，在form中是label
 * @method $this tooltip(string $tooltip)                              会在 title 旁边展示一个 icon，鼠标浮动之后展示
 * @method $this valueType(string $valueType)                          值的类型,会生成不同的渲染器
 * @method $this valueEnum(array $valueEnum)                           值的枚举，会自动转化把值当成 key 来取出要显示的内容
 * @method $this request(string $request)                              传递给 Form.Item 的配置
 * @method $this initialValue($initialValue)                           查询表单/表单项初始值
 * @method $this colSize(int $colSize)                                 一个表单项占用的格子数量, 占比 = colSize*span，colSize 默认为 1 ，span 为 8，span是form = {{span:8}} 全局设置的
 * @method $this order(int $order)                                     查询表单中的权重，权重大排序靠前
 * @method $this quickEditEnabledOn(string $quickEditEnabledOn)        快速编辑启用条件

 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn
 */
class Column extends BaseRenderer
{
    use FieldAttribute;

    /**
     * @var string
     */
    protected string $valueType = 'text';

    /**
     * @var Collection
     */
    protected Collection $dependencies;

    /**
     * @var Collection
     */
    protected Collection $dependency;

    /**
     * construct Column
     * @param string|null $dataIndex
     * @param string|null $title
     * @param string|null $valueType
     */
    public function __construct(?string $dataIndex = null, ?string $title = null, ?string $valueType = null)
    {
        !is_null($dataIndex) && $this->set('dataIndex', $dataIndex);
        !is_null($title) && $this->set('title', $title);
        !is_null($valueType) && $this->valueType($valueType);
        $this->dependencies = new Collection();
        $this->dependency = new Collection();
        $this->fieldProp('id', uniqid(($dataIndex ?? '') . '_'));
    }

    /**
     * 是否支持复制
     * @param bool $copyable
     * @return $this
     */
    public function copyable(bool $copyable = true): self
    {
        return $this->set('copyable', $copyable);
    }

    /**
     * 是否自动缩略
     * @param array|bool $ellipsis boolean | {showTitle?: boolean}
     * @return $this
     */
    public function ellipsis(array|bool $ellipsis = true): self
    {
        return $this->set('ellipsis', $ellipsis);
    }

    /**
     * 在编辑表格中是否可编辑的，函数的参数和 table 的 render 一样
     * @param bool|array $editable false | (text: any, record: T,index: number) => boolean
     * @default true
     * @return $this
     */
    public function editable(bool|array $editable = true): self
    {
        return $this->set('editable', $editable);
    }

    /**
     * 在 descriptions 中隐藏
     * @param bool $hideInDescriptions
     * @return $this
     */
    public function hideInDescriptions(bool $hideInDescriptions = true): self
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
        return $this->set('search', !$hideInSearch);
    }

    /**
     * 在 Table 中不展示此列
     * @param bool $hideInTable
     * @return $this
     */
    public function hideInTable(bool $hideInTable = true): self
    {
        return $this->set('hideInTable', $hideInTable);
    }

    /**
     * 在 Form 中不展示此列
     * @param bool $hideInForm
     * @return $this
     */
    public function hideInForm(bool $hideInForm = true): self
    {
        return $this->set('hideInForm', $hideInForm);
    }

    /**
     * 忽略存储选项
     * @param bool $ignore
     * @return $this
     */
    public function ignore(bool $ignore = true): self
    {
        return $this->set('ignore', $ignore);
    }

    /**
     * 表头的筛选菜单项，当值为 true 时，自动使用 valueEnum 生成
     * @param array|bool $filters
     * @return $this
     */
    public function filters(bool|array $filters = true): self
    {
        return $this->set('filters', $filters);
    }

    /**
     * 配置列的搜索相关，false 为隐藏
     * @param bool $search false | { transform: (value: any) => any }
     * @default true
     * @return $this
     */
    public function search(bool $search = false): self
    {
        return $this->set('search', $search);
    }

    /**
     * 列设置中disabled的状态
     * @param bool|array $disable boolean | { checkbox: boolean; }
     * @return $this
     */
    public function disable(bool|array $disable = true): self
    {
        return $this->set('disable', $disable);
    }

    /**
     * 列设置排序
     * @param bool $sorter boolean
     * @return $this
     */
    public function sorter(bool $sorter = true): self
    {
        return $this->set('sorter', $sorter);
    }

    /**
     * 默认内容
     * @param $value
     * @return $this
     */
    public function defaultValue($value): self
    {
        return $this->fieldProp('defaultValue', $value);
    }

    /**
     * 设置到 ProField 上面的 props，内部属性
     * @param string $field
     * @param $props
     * @return $this
     */
    public function proFieldProp(string $field, $props): self
    {
        if (!isset($this->proFieldProps)) {
            $this->set('proFieldProps', new Collection());
        }
        $this->proFieldProps->put($field, $props);
        return $this;
    }

    /**
     * 表单联动项
     * @param string $field
     * @param numeric-string|null $value
     * @param string $condition '=', '>', '<', '>=', '<=', 'has', '!=', 'in', 'notIn'
     * @return $this
     * @throws RendererException
     */
    public function when(string $field, ?string $value = null, string $condition = '='): self
    {
//        is_null($value) && $value = $condition && $condition = '=';
        if (!in_array($condition, ['=', '>', '<', '>=', '<=', 'has', '!=', 'in', 'notIn'])) {
            throw new RendererException("Dependency conditions must be in '=', '>', '<', '>=', '<=', 'has', '!=', 'in', 'notIn'");
        }
        if (!is_null($value)) {
            $condition = $value;
            $value = null;
        }
        if (in_array($condition, ['in', 'notIn']) && !is_array($value)) {
            throw new RendererException("When the Dependencies Condition is 'in' or 'notIn', the value must be array");
        }
        $this->dependencies->push($field);
        $this->dependency->put($field, ['condition' => $condition , 'value' => $value]);
        return $this;
    }

    /**
     * @param string|array $field
     * @return $this
     */
    public function dependencies(string|array $field): self
    {
        if (is_string($field)) {
            $this->dependencies->push($field);
        } else {
            foreach ($field as $item) {
                $this->dependencies->push($item);
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function render(): array
    {
        if (!$this->fieldProps->get('placeholder') && !in_array($this->valueType, ['switch', 'dependency']) && (!isset($this->hideInSearch) || !$this->hideInSearch || !isset($this->hideInForm) || !$this->hideInForm)) {
            $title = $this->title ?? $this->dataIndex;
            if (in_array($this->valueType, ['select', 'checkbox', 'radio', 'radioButton', 'tree', 'cascader', 'treeSelect', 'time', 'timeRange', 'rate', 'avatar', 'iconSelect']) || Str::startsWith('date', $this->valueType)) {
                $tip = '选择';
            } else {
                $tip = '输入';
            }
            if (Str::endsWith($this->valueType, 'Range')) {
                $this->fieldProps->put('placeholder', ["起始{$title}", "截止{$title}"]);
            } else {
                $this->fieldProps->put('placeholder', "请{$tip}{$title}");
            }

        }
        return parent::render();
    }
}