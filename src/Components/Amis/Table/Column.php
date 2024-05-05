<?php
namespace Gentle\Edith\Components\Amis\Table;

use Gentle\Edith\Components\BaseRenderer;
use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis Table Column
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/crud
 * @method $this label(string $label)                   表头文本内容
 * @method $this name(string $name)                     通过名称关联数据
 * @method $this width($width)                          列宽 string | int
 * @method $this remark(string $remark)                 提示信息
 * @method $this popOver($popOver)                      弹出框
 * @method $this filterable($filterable)                是否可快速搜索，options属性为静态选项，支持设置source属性从接口获取选项 默认： false
 * @method $this src(string $src)                       动态定义 头像/图片 模型字段
 * @method $this quickEditEnabledOn(string $enable)     配置快速编辑启动条件
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Column extends BaseRenderer
{
    /**
     * 默认列为文本类型
     * @var string
     */
    protected string $type = 'text';

    /**
     * construct column
     * @param string|null $name 通过名称关联数据
     * @param string|null $label 表头文本内容
     */
    public function __construct(?string $name = null, ?string $label = null)
    {
        !is_null($name) && $this->set('name', $name);
        !is_null($label) && $this->set('label', $label);
    }

    /**
     * 是否固定当前列
     * @param string $fixed left | right | none
     * @return $this
     * @throws \Exception
     */
    public function fixed(string $fixed): Column
    {
        if (!in_array($fixed, ['left', 'right', 'none'])) {
            throw new \Exception("Table Column only supports 'left', 'right', 'none'");
        }
        return $this->set('fixed', $fixed);
    }

    /**
     * 列类型
     * @param string $type
     * @return $this
     */
    public function type(string $type): Column
    {
        return $this->set('type', $type);
    }

    /**
     * 是否可快速搜索，开启autoGenerateFilter后，searchable支持配置Schema  默认： false
     * @param string $type 搜索表单类型 支持 input-text | select
     * @param string|null $placeholder 搜索表单占位符
     * @param array|null $options 搜索表单选项，仅 type 为 select 时有效
     * @param string|null $name 搜索表单字段名称
     * @param string|null $label 搜索表单 Label
     * @return Column
     * @throws RendererException
     */
    public function searchable(string $type = 'input-text', ?string $placeholder = null, ?array $options = null, ?string $name = null, ?string $label = null): Column
    {
        if (isset($this->map) && is_array($this->map)) {
            $type = 'select';
            $options = $this->map;
        }
        if (empty($placeholder)) {
            $placeholder = ($type == 'select' ? '请选择' : '请输入') . ($label ?: ($this->label ?? ''));
        }
        if ($type == 'select' && !is_array($options)) {
            throw new RendererException('Missing options in CRUD search form');
        }
        if (empty($name) && !isset($this->name)) {
            throw new RendererException('Missing name in CRUD search form');
        }
        $searchable = [
            'type' => $type,
            'name' => $name ?: $this->name,
            'label' => $label ?: $this->label,
            'placeholder' => $placeholder,
            'options' => $options
        ];
        return $this->set('searchable', $searchable);
    }

    /**
     * 是否可排序
     * @param bool $sortable
     * @default false
     * @return Column
     */
    public function sortable(bool $sortable = true): Column
    {
        return $this->set('sortable', $sortable);
    }

    /**
     * 是否可复制
     * @param bool|object $copyable boolean 或 {icon: string, content:string}
     * @default false
     * @return Column
     */
    public function copyable($copyable = true): Column
    {
        return $this->set('copyable', $copyable);
    }

    /**
     * 是否默认隐藏
     * @param bool|object $toggled boolean
     * @default false
     * @return Column
     */
    public function toggled(bool $toggled = false): Column
    {
        return $this->set('toggled', $toggled);
    }

    /**
     * 底部展示列
     * @return Column
     */
    public function breakpoint(): Column
    {
        return $this->set('breakpoint', '*');
    }

    /**
     * 映射
     * @param array $mapping
     * @return Column
     */
    public function map(array $mapping): Column
    {
        if ($this->type != 'mapping') {
            $this->type = 'mapping';
        }
        return $this->set('map', $mapping);
    }

    /***
     * 快速编辑，一般需要配合quickSaveApi接口使用
     * @param bool|array|QuickEditConfig $quickEdit
     * @return Column
     */
    public function quickEdit($quickEdit = true): Column
    {
        return $this->set('quickEdit', $quickEdit);
    }
}
