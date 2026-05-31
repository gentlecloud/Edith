<?php
namespace Edith\Admin\Components\Forms;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Columns\Item\UploaderColumn;
use Edith\Admin\Exceptions\RendererException;

/**
 * Antd Schema Form - JSON 表单
 * SchemaForm 是根据 JSON Schema 来生成表单的工具。SchemaForm 会根据 valueType 来映射成不同的表单项。
 * 参考文档： https://procomponents.ant.design/components/schema-form#proformlayouttype
 * @method $this steps(array $steps)                                      layoutType=steps中的分步表单配置，需要配置 columns 为数组使用  StepFormProps[]
 * @method $this title(string $title)                                     modal 和 drawer 表单可设置标题
 * @method Column text(string $dataIndex, ?string $title = null)          图片表单 FormItem
 * @method Column password(string $dataIndex, ?string $title = null)      生成表单 FormItem.Password
 * @method UploaderColumn uploader(string $dataIndex, ?string $title = null)    生成表单 FormItem.uploader 图片上传组件
 * @method UploaderColumn file(string $dataIndex, ?string $title = null)        生成表单 FormItem.file 文件上传组件
 * @method Column image(string $dataIndex, ?string $title = null)         生成表单 FormItem.image 图片预览组件
 * @method Column radio(string $dataIndex, ?string $title = null)         生成表单 FormItem.Radio 单选框
 * @method Column switch(string $dataIndex, ?string $title = null)        生成表单 FormItem.Switch 开关
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.ieda.cc
 */
class SchemaForm extends ProForm
{

    /**
     * @var string
     */
    public string $renderer = 'schema-form';

    /**
     * @var string
     */
    protected string $layoutType = 'form';

    /**
     * modal drawer 表单按钮类型
     * @var Action|null
     */
    protected ?Action $trigger;

    /**
     * @var array|string[]
     */
    protected static array $columnInputs = [
        'text',
        'digit',
        'password',
        'textarea',
        'date',
        'datetime',
        'dateRange',
        'datetimeRange',
        'select',
        'tree',
        'checkbox',
        'radio',
        'slider',
        'switch',
        'file',
        'uploader',
        'image',
        'money',
        'segmented'
    ];

    /**
     * @param string|Action|null $button
     */
    public function __construct(string|Action|null $button = null)
    {
        parent::__construct();
        if ($button) {
            $this->trigger = is_string($button) ? (new Action($button))
                ->type('primary')
                ->size('small')
                ->actionType($this->renderer) : $button;
        }
    }

    /**
     * 使用的表单布局模式
     * @param string $layoutType 'Form' | 'ModalForm' | 'DrawerForm' | 'StepsForm' | 'StepForm' | 'LightFilter' | 'QueryFilter' | 'Embed'
     * @return SchemaForm
     * @throws RendererException
     */
    public function layoutType(string $layoutType): SchemaForm
    {
        $layoutType = ucfirst($layoutType);
        if (!in_array($layoutType, ['Form', 'ModalForm', 'DrawerForm', 'StepsForm', 'StepForm', 'LightFilter', 'QueryFilter', 'Embed'])) {
            throw new RendererException("SchemaForm layoutType only Support Form, ModalForm, DrawerForm, StepsForm, StepForm, LightFilter, QueryFilter, Embed");
        }
        return $this->set('layoutType', $layoutType);
    }

    /**
     * 细粒化控制是否渲染。
     * 为true时会自动重新渲染表单项。
     * 为false时不会更新表单项但可以使用dependencies 触发更新，
     * 为function 时根据返回值判断是否重新渲染表单项，等同直接赋值 true 或 false 参考示例
     * @param bool $shouldUpdate
     * @default false
     * @return SchemaForm
     */
    public function shouldUpdate(bool $shouldUpdate = true): SchemaForm
    {
        return $this->set('shouldUpdate', $shouldUpdate);
    }

    /**
     * 添加表格列
     * @param string|null $name 关联字段
     * @param string|null $label 表头
     * @return Column
     */
    public function column(?string $name = null, ?string $label = null): Column
    {
        return tap(new Column($name, $label), function ($value) {
            $this->columns->push($value);
        });
    }

    /**
     * 表单隐藏项
     * @param string|null $dataIndex
     * @param string|null $title
     * @return SchemaForm
     */
    public function hidden(?string $dataIndex = 'id', ?string $title = null): SchemaForm
    {
        $this->columns->push((new Column($dataIndex, $title))->hidden());
        return $this;
    }

    /**
     * modal 和 drawer 表单按钮类型 link or button
     * @param $level
     * @return $this
     */
    public function labelLevel($level = 'link')
    {
        $this->trigger['type'] = $level;
        return $this;
    }

    /**
     * modal 和 drawer 表单按钮名称
     * @param string $label
     * @return $this
     */
    public function label(string $label)
    {
        $this->trigger->label($label);
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return SchemaForm|Column
     */
    public function __call($name, $arguments)
    {
        if (in_array($name, self::$columnInputs)) {
            if (in_array($name, ['uploader', 'file'])) {
                $column = new UploaderColumn(...$arguments);
            } else {
                $column = new Column(...$arguments);
                if ($name == 'switch') {
                    $column->fieldProp('unCheckedChildren', '禁用')->fieldProp('checkedChildren', '启用');
                }
            }
            return tap($column->valueType($name), function ($value) {
                $this->columns->push($value);
            });
        } else {
            return parent::__call($name, $arguments);
        }
    }
}