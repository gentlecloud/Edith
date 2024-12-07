<?php
namespace Edith\Admin\Components\Fields;

use Edith\Admin\Components\Renderer;
use Illuminate\Support\Collection;

/**
 * @method $this name(string $name)                          Field name
 * @method $this label(string $label)                        Field label
 * @method $this placeholder(string $placeholder)            Field input 占位符
 * @method $this tooltip(string $tooltip)                    会在 label 旁增加一个 icon，悬浮后展示配置的信息
 * @method $this rowProps(array $rowProps)                   开启 grid 模式时传递给 Row, 仅在ProFormGroup, ProFormList, ProFormFieldSet 中有效 默认： { gutter: 8 }
 * @method $this colProps(array $colProps)                   开启 grid 模式时传递给 Col 默认： { xs: 24 }
 * @method $this min(int $min)                               最小位数 digit
 * @method $this max(int $max)                               最大位数 digit
 * @method $this maxLength(int $maxLength)                   最大长度
 * @method $this valueEnum(array $valueEnum)                 当前列值的枚举 valueEnum (select...等使用)
 * @method $this options(array $options)                     与 select 相同，根据 options 生成子节点，推荐使用。 (checkbox, radio, cascader)  {['农业', '制造业', '互联网']}
 * @method $this layout(string $layout)                      配置 checkbox 的样子，支持  vertical | horizontal
 * @method $this radioType(string $radioType)                设置是按钮模式还是 radio 模式   default|button
 * @method $this initialValue($initialValue)                 默认内容
 * @method $this value($value)                               输入框内容
 * @method $this size(string $size)                          控件大小。注：标准表单内的输入框大小限制为 middle,  支持枚举   large | middle | small
 * @method $this autoSize($autoSize)                         自适应内容高度，可设置为 true | false 或对象：{ minRows: 2, maxRows: 6 } (textarea)
 * @method $this prefix($prefix)                             带有前缀图标的 input
 * @method $this suffix($suffix)                             带有后缀图标的 input
 * @method $this addonBefore($addonBefore)                   带标签的 input，设置前置标签
 * @method $this addonAfter($addonAfter)                     带标签的 input，设置后置标签
 * @method $this disabled(bool $disabled)                    是否禁用状态，默认为 false
 * @method $this id(string $id)                              输入框的 id
 * @method $this showCount(bool $showCount)                  是否展示字数
 * @method $this bordered(bool $bordered)                    是否有边框
 * @method $this help(string $help)                          提示帮助信息
 * @method $this action(string $api)                         文件上传后端API
 * @method $this accept(string $accept)                      文件上传支持后缀
 * @method $this listType(string $listType)                  上传列表的内建样式，支持四种基本样式 text, picture, picture-card 和 picture-circle
 * @method $this visibleOn(string $rule)
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Field extends Renderer
{
    /**
     * 无需透传的方法
     * @var array|string[]
     */
    protected array $methods = [
        'renderer',
        'name',
        'title',
        'label',
        'placeholder',
        'tooltip',
        'allowClear',
        'rowProps',
        'colProps',
        'min',
        'max',
        'valueEnum',
        'options',
        'layout',
        'radioType',
        'initialValue',
        'visibleOn',
        'source',
        'onEvent',
        'validateApi',
        'initApi',
        'autoComplete',
        'autoFill',
        'hidden',
        'captcha',
        'engine',
        'help',
        'extra',
        'id'
    ];

    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    public string $renderer = 'text';

    /**
     * 使用引擎，默认使用 Ant Design，若为 Amis 则使用 Amis 规则生成表单校验, Label等..
     * @var string
     */
    protected string $engine = 'ant';

    /**
     * Ant ProFormFields 渲染类型
     * @var string
     */
    protected string $type = 'custom-fields';

    /**
     * 透传 input 属性
     * @var Collection
     */
    protected Collection $fieldProps;

    /**
     * 表单校验规则
     * @var Collection
     */
    protected Collection $rules;

    /**
     * construct ant fields
     * @param string|null $name Input name
     * @param string|null $label Input label
     */
    public function __construct(?string $name = null, ?string $label = null)
    {
        parent::__construct();
        !is_null($name) && $this->set('name', $name);
        $fieldProps = [];
        if (!empty($label)) {
            $fieldProps['placeholder'] = "请输入{$label}";
        }
        if (!is_null($label)) {
            $this->set('label', $label);
        }
        $this->fieldProps = new Collection($fieldProps);
        $this->rules = new Collection();
    }

    /**
     * 支持清除，针对 LightFilter 下有效，主动设置情况下同时也会透传给 fieldProps
     * @param bool $allowClear
     * @return Field
     */
    public function allowClear(bool $allowClear = true): Field
    {
        return $this->set('allowClear', $allowClear);
    }

    /**
     * 是否是次要控件，只针对 LightFilter 下有效
     * @param bool $secondary
     * @return Field
     */
    public function secondary(bool $secondary = true): Field
    {
        return $this->set('secondary', $secondary);
    }

    /**
     * Field 的长度，我们归纳了常用的 Field 长度以及适合的场景
     * @param numeric|string $width 宽度, 支持了一些枚举 "xs" | "sm" | "md" | "lg" | "xl"
     * @return Field
     * @throws \Exception
     */
    public function width($width): Field
    {
        if (!is_numeric($width) && !in_array($width, ["xs" , "sm" , "md" ,"lg" , "xl"])) {
            throw new \Exception("Width only supports setting 'xs', 'sm', 'md', 'lg', 'xl'");
        }
        return $this->set('width', $width);
    }

    /**
     * @param array $rules 表单规则
     * @param array $messages 错误信息
     * @return $this
     */
    public function rule(array $rules, array $messages): Field
    {
        foreach ($rules as $row) {
            if (!isset($messages[$row])) {
                continue;
            }
            $arr = [];
            if (str_contains($row,':')) {
                $arr = explode(':', $row);
                $rule = $arr[0];
            } else {
                $rule = $row;
            }
            $data = [];
            switch ($rule) {
                case 'required':
                    // 必填
                    $data['required'] = true;
                    $data['message'] = $messages['required'];
                    break;
                case 'min':
                    // 最小字符串数
                    $data['min'] = intval($arr[1]);
                    $data['message'] = $messages['min'];
                    break;
                case 'max':
                    // 最大字符串数
                    $data['max'] = intval($arr[1]);
                    $data['message'] = $messages['max'];
                    break;
                case 'email':
                    // 必须为邮箱
                    $data['type'] = 'email';
                    $data['message'] = $messages['email'];
                    break;
                case 'numeric':
                    // 必须为数字
                    $data['type'] = 'number';
                    $data['message'] = $messages['numeric'];
                    break;
                case 'url':
                    // 必须为url
                    $data['type'] = 'url';
                    $data['message'] = $messages['url'];
                    break;
                case 'integer':
                    // 必须为整数
                    $data['type'] = 'integer';
                    $data['message'] = $messages['integer'];
                    break;
                case 'date':
                    // 必须为日期
                    $data['type'] = 'date';
                    $data['message'] = $messages['date'];
                    break;
                case 'boolean':
                    // 必须为布尔值
                    $data['type'] = 'boolean';
                    $data['message'] = $messages['boolean'];
                    break;
            }

            $data && $this->rules->push($data);
        }
        return $this;
    }

    /**
     * 生成 Ant Field 校验规则
     * @param array $rules Laravel 表单校验规则
     * @param array $messages Laravel 表单校验规则错误提示
     * @return $this
     */
    public function fillRules(array $rules, array $messages): Field
    {
        foreach ($rules as $field => $rule) {
            if (!isset($this->name) || $field != $this->name) {
                continue;
            }
            $rows = explode("|", $rule);
            foreach ($rows as $row) {
                $message = $messages["{$field}.{$row}"] ?? null;
                $data = [];
                if ($row == 'required') {
                    $data[$row] = true;
                } else if (str_contains($row, ':')) {
                    $value = explode(":", $row);
                    if (in_array($value[0], ['min', 'max'])) {
                        $data[$value[0]] = $value[1];
                    } else {
                        $data['type'] = $value[0];
                    }
                } else {
                    $data['type'] = $row == 'numeric' ? 'number' : $row;
                }
                !is_null($message) && $data['message'] = $message;
                $this->rules->push($data);
            }
            break;
        }
        return $this;
    }

    /**
     * 隐藏项
     * @param bool $hidden
     * @return Field
     */
    public function hidden(bool $hidden = true): Field
    {
        return $this->set('hidden', $hidden);
    }

    /**
     * 表单引擎
     * @param string $engine
     * @return Field
     */
    public function engine(string $engine): Field
    {
        return $this->set('engine', $engine);
    }

    /**
     * 附件上传
     * @param string $type
     * @param int $max
     * @param $api
     * @return $this
     */
    public function upload(string $type = 'image/*', int $max = 1, $api = null)
    {
        $this->set('action', $api ?: url('api/attachments/upload'));
        $this->set('max', $max);
        $this->set('accept', $type);
        $this->set('multiple', $max > 1);
        $this->renderer = 'uploader';
        return $this;
    }

    /**
     * 上传多选数量
     * @param int $number
     * @return Field
     */
    public function multiple(int $number = 1): Field
    {
        $this->set('max', $number);
        return $this->set('multiple', $number > 1);
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments): Field
    {
        if (!in_array($name, $this->methods)) {
            $this->fieldProps->put($name, array_shift($arguments));
            return $this;
        }
        return parent::__call($name, $arguments); // TODO: Change the autogenerated stub
    }

    /**
     * custom render JSON
     * @return array
     */
    public function render(): array
    {
        unset($this->methods);
        $renderer = get_object_vars($this);

        return [
            'type' => $this->type,
            'engine' => $this->engine,
            'renderer' => $renderer,
            'name' => $renderer['name'],
            'label' => $this->engine === 'ant' ? null : $renderer['label'],
            'visibleOn' => $renderer['visibleOn'] ?? null,
            'autoFill' => $renderer['autoFill'] ?? null,
            'id' => $this->id ?? 'input-captcha'
        ];
    }
}