<?php
namespace Gentle\Edith\Components\Forms;

use Gentle\Edith\Components\Amis\Service;
use Gentle\Edith\Components\Fields\Field;
use Gentle\Edith\Components\Renderer;
use Gentle\Edith\Components\Tabs\Tabs;
use Gentle\Edith\Components\Traits\FormActions;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Antd ProForm 表单
 * 参考文档： https://procomponents.ant.design/components/form
 * @method $this dateFormatter($dateFormatter)                自动格式数据,主要是 moment 的表单,支持 string 和 number 两种模式，此外还支持指定函数进行格式化。 string| number | ((value: Moment, valueType: string) => string | number) | false
 * @method $this params($params)                              发起网络请求的参数,与 request 配合使用
 * @method $this request(string $request)                     发起网络请求的参数,返回值会覆盖给 initialValues
 * @method $this rowProps(array $rowProps)                    开启 grid 模式时传递给 Row, 仅在ProFormGroup, ProFormList, ProFormFieldSet 中有效 默认：{ gutter: 8 }
 * @method $this labelAlign(string $labelAlign)               label 标签的文本对齐方式 left | right
 * @method $this labelCol(array $labelCol)                    label 标签布局，同 <Col> 组件，设置 span offset 值，如 {span: 3, offset: 12} 或 sm: {span: 3, offset: 12}
 * @method $this name(string $name)                           表单名称，会作为表单字段 id 前缀使用
 * @method $this wrapperCol(array $wrapperCol)                需要为输入控件设置布局样式时，使用该属性，用法同 labelCol
 * @method $this width($width)                                表单宽度
 * @method $this api($api)                                    表单后端 API 接口 格式 : {"method": "POST", "url: "/api/edith/store", "dataType": "form-data" }  dataType 非必须,默认 json
 * @method $this redirect(string $redirect)                   表单保存后跳转链接
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class ProForm extends Renderer
{
    use FormActions;

    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $renderer = 'pro-form';

    /**
     * 表单列
     * @var Collection
     */
    protected Collection $columns;

    /**
     * 表单初始化数据
     * @var array|null
     */
    protected ?array $initialValues = [];

    /**
     * construct ProForm
     */
    public function __construct()
    {
        parent::__construct();
        $this->columns = new Collection();
    }


    /**
     * 设置列信息
     * @param array|Collection $columns
     * @return ProForm
     */
    public function columns($columns): ProForm
    {
        if ($columns instanceof Collection) {
            $this->columns = $columns;
        } else {
            $this->columns = new Collection($columns);
        }
        return $this;
    }

    /**
     * 表单默认值，只有初始化以及重置时生效
     * @param array|null $initialValues
     * @return ProForm
     */
    public function initialValues(?array $initialValues = null): ProForm
    {
//        foreach ($this->columns as $column) {
//            var_dump($column);
//        }
        return $this->set('initialValues', $initialValues);
    }

    /**
     * 添加表格列
     * @param string|null $name 关联字段
     * @param string|null $label 表头
     * @return Field|Column
     */
    public function column(?string $name = null, ?string $label = null)
    {
        return tap(new Field($name, $label), function ($value) {
            $this->columns->push($value);
        });
    }

    /**
     * 表示是否显示 label 后面的冒号 (只有在属性 layout 为 horizontal 时有效)
     * @param bool $colon
     * @default true
     * @return ProForm
     */
    public function colon(bool $colon = false): ProForm
    {
        return $this->set('colon', $colon);
    }

    /**
     * 设置表单组件禁用，仅对 antd 组件有效
     * @param bool $disabled
     * @default false
     * @return ProForm
     */
    public function disabled(bool $disabled = true): ProForm
    {
        return $this->set('disabled', $disabled);
    }

    /**
     * ProForm 会自动清空 null 和 undefined 的数数据，如果你约定了 nil 代表某种数据，可以设置为 false 关闭此功能
     * @param bool $omitNil
     * @default true
     * @return ProForm
     */
    public function omitNil(bool $omitNil = false): ProForm
    {
        return $this->set('omitNil', $omitNil);
    }

    /**
     * 是否使用回车提交
     * @param bool $isKeyPressSubmit
     * @return ProForm
     */
    public function isKeyPressSubmit(bool $isKeyPressSubmit = true): ProForm
    {
        return $this->set('isKeyPressSubmit', $isKeyPressSubmit);
    }

    /**
     * 自动 focus 表单第一个输入框
     * @param bool $autoFocusFirstInput
     * @return ProForm
     */
    public function autoFocusFirstInput(bool $autoFocusFirstInput = true): ProForm
    {
        return $this->set('autoFocusFirstInput', $autoFocusFirstInput);
    }

    /**
     * 开启栅格化模式，宽度默认百分比，请使用 colProps 控制宽度 查看示例
     * @param bool $grid
     * @return ProForm
     */
    public function grid(bool $grid = true): ProForm
    {
        return $this->set('grid', $grid);
    }

    /**
     * 同步结果到 initialValues,默认为 true 如果为 false，form.reset 的时将会忽略从 url 上获取的数据
     * @param bool $syncToInitialValues
     * @default true
     * @return ProForm
     */
    public function syncToInitialValues(bool $syncToInitialValues = false): ProForm
    {
        return $this->set('syncToInitialValues', $syncToInitialValues);
    }

    /**
     * 表单布局
     * @param string $layout horizontal | vertical | inline
     * @default horizontal
     * @return ProForm
     * @throws RendererException
     */
    public function layout(string $layout): ProForm
    {
        if (!in_array($layout, ['horizontal', 'vertical', 'inline'])) {
            throw new RendererException("Layout only supports setting 'horizontal', 'vertical' or 'inline'");
        }
        return $this->set('layout', $layout);
    }

    /**
     * label 标签的文本换行方式
     * @param bool $labelWrap
     * @default false
     * @return ProForm
     */
    public function labelWrap(bool $labelWrap = true): ProForm
    {
        return $this->set('labelWrap', $labelWrap);
    }

    /**
     * 当字段被删除时保留字段值
     * @param bool $preserve
     * @default true
     * @return ProForm
     */
    public function preserve(bool $preserve = false): ProForm
    {
        return $this->set('preserve', $preserve);
    }

    /**
     * 必选样式，可以切换为必选或者可选展示样式。此为 Form 配置，Form.Item 无法单独配置
     * @param bool|array $requiredMark
     * @return ProForm
     */
    public function requiredMark($requiredMark = false): ProForm
    {
        return $this->set('requiredMark', $requiredMark);
    }

    /**
     * 提交失败自动滚动到第一个错误字段
     * @param bool $scrollToFirstError
     * @default false
     * @return ProForm
     */
    public function scrollToFirstError(bool $scrollToFirstError = true): ProForm
    {
        return $this->set('scrollToFirstError', $scrollToFirstError);
    }

    /**
     * 设置字段组件的尺寸（仅限 antd 组件）
     * @param string $size small | middle | large
     * @return ProForm
     * @throws RendererException
     */
    public function size(string $size): ProForm
    {
        if (!in_array($size, ['small', 'middle', 'large'])) {
            throw new RendererException("Size only supports setting 'small', 'middle' or 'large'");
        }
        return $this->set('size', $size);
    }

    /**
     * 初始化默认提交 Api
     * @param int|string|null $id 编辑索引 ID
     * @return $this
     */
    public function initApi($id = null): ProForm
    {
        $api = $this->makeActionApi($id);
        $this->onAction()->redirect($this->redirect ?? null)->api($api);
        $this->set('name', $this->uniqid); // class_basename(get_called_class())
        return $this;
    }

    /**
     * 确保存在表单保存 API 修改默认 render 方法
     * @return array
     */
    public function render(): array
    {
        if (!isset($this->api)) {
            $this->initApi();
        }
        if ($this->renderer == 'tabs-form') {
            foreach ($this->tabs as $tab) {
                foreach ($tab->children as $column) {
                    $this->extracted($column);
                }
            }
            $this->renderer = 'pro-form';
            $this->columns->push((new Tabs())->items($this->tabs));
            unset($this->tabs);
        } else {
            foreach ($this->columns as $column) {
                $this->extracted($column);
            }
        }
        return (new Service())->body(parent::render())->data($this->initialValues)->render();
    }

    /**
     * @param $column
     */
    protected function extracted($column): void
    {
        if (!isset($column->dataIndex) && !isset($column->name)) {
            return;
        }
        $dataIndex = $column->dataIndex ?? $column->name;
        if (!isset($this->initialValues[$dataIndex]) && isset($column->initialValue)) {
            $this->initialValues[$dataIndex] = $column->initialValue;
        }
        if (isset($column->valueType) || isset($column->renderer)) {
            $valueType = $column->valueType ?? $column->renderer;
            if (isset($this->initialValues[$dataIndex]) && in_array($valueType, ['radio', 'tree'])) {
                $this->initialValues[$dataIndex] = strval($this->initialValues[$dataIndex]);
            }
            if (isset($this->initialValues[$dataIndex]) && $valueType == 'switch') {
                $this->initialValues[$dataIndex] = $this->initialValues[$dataIndex] == 1 || $this->initialValues[$dataIndex] == 'open';
            }
            if (!empty($this->initialValues[$dataIndex]) && in_array($valueType, ['upload', 'uploader'])) {
                $value = [];
                if (is_string($this->initialValues[$dataIndex])) {
                    if ($attachment = get_attachment($this->initialValues[$dataIndex], 'all'))
                        $value[] = $attachment;
                } else {
                    foreach ($this->initialValues[$dataIndex] as $row) {
                        if (!$row) {
                            continue;
                        }
                        if (is_string($row)) {
                            $attachment = get_attachment($row, 'all');
                            if ($attachment) {
                                $value[] = $attachment;
                            }
                        } else {
                            $value[] = $row;
                        }
                    }
                }
                $this->initialValues[$dataIndex] = $value;
            }
        }
        unset($column->initialValue);
    }
}