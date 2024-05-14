<?php
namespace Edith\Admin\Components\Forms;

use Edith\Admin\Components\Fields\Column as BasicColumn;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Antd Form Column 表单列
 * @method $this dataIndex(string $dataIndex)                           与实体映射的 key，数组会被转化 [a,b] => Entity.a.b
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Column extends BasicColumn
{
    /**
     * 设置到 ProField 上面的 props，内部属性
     * @var Collection
     */
    protected Collection $proFieldProps;

    /**
     * @var Collection
     */
    protected Collection $dependencies;

    /**
     * @var Collection
     */
    protected Collection $dependency;

    /**
     * construct Form Column
     * @param string|null $dataIndex
     * @param string|null $title
     */
    public function __construct(?string $dataIndex = null, ?string $title = null)
    {
        parent::__construct($dataIndex, $title);
        $this->proFieldProps = new Collection();
        $this->dependencies = new Collection();
        $this->dependency = new Collection();
    }

    /**
     * 表单只读设置
     * @param bool $readonly
     * @return Column
     */
    public function readonly(bool $readonly = true): Column
    {
        return $this->set('readonly', $readonly);
    }

    /**
     * 忽略存储选项
     * @param bool $ignore
     * @return Column
     */
    public function ignore(bool $ignore = true): Column
    {
        return $this->set('ignore', $ignore);
    }

    /**
     * 设置到 ProField 上面的 props，内部属性
     * @param string $field
     * @param $props
     * @return Column
     */
    public function proFieldProp(string $field, $props): Column
    {
        return $this->set('proFieldProps', $this->proFieldProps->put($field, $props));
    }

    /**
     * 表单联动项
     * @param string $field
     * @param string|numeric|null $value
     * @param string $condition '=', '>', '<', '>=', '<=', 'has', '!=', 'in', 'notIn'
     * @return Column
     * @throws RendererException
     */
    public function dependencies(string $field, $value = null, string $condition = '='): Column
    {
        is_null($value) && $value = $condition && $condition = '=';
        if (!in_array($condition, ['=', '>', '<', '>=', '<=', 'has', '!=', 'in', 'notIn'])) {
            throw new RendererException("Dependency conditions must be in '=', '>', '<', '>=', '<=', 'has', '!=', 'in', 'notIn'");
        }
        if (in_array($condition, ['in', 'notIn']) && !is_array($value)) {
            throw new RendererException("When the Dependencies Condition is 'in' or 'notIn', the value must be array");
        }
        $this->dependencies->push($field);
        $this->dependency->put($field, ['condition' => $condition , 'value' => $value]);
        return $this;
    }
}