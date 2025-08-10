<?php
namespace Edith\Admin\Components\Fields;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Components\Traits\Fields\FieldAttribute;
use Illuminate\Support\Collection;

/**
 * @method $this name(string $name)                          Field name
 * @method $this label(string $label)                        Field label
 * @method $this min(int $min)                               最小位数 digit
 * @method $this max(int $max)                               最大位数 digit
 * @method $this valueEnum(array $valueEnum)                 当前列值的枚举 valueEnum (select...等使用)
 * @method $this layout(string $layout)                      配置 checkbox 的样子，支持  vertical | horizontal
 * @method $this radioType(string $radioType)                设置是按钮模式还是 radio 模式   default|button
 * @method $this initialValue($initialValue)                 默认内容
 * @method $this bordered(bool $bordered)                    是否有边框
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Field extends EngineRenderer
{
    use FieldAttribute;

    /**
     * 无需透传的方法
     * @var array|string[]
     */
    protected array $methods = [
        'style',
        'name',
        'title',
        'label',
        'tooltip',
        'rowProps',
        'colProps',
        'valueEnum',
        'layout',
        'radioType',
        'initialValue',
        'source',
        'onEvent',
        'validateApi',
        'initApi',
        'autoComplete',
        'captcha',
        'engine'
    ];

    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    public string $renderer = 'custom-fields';

    /**
     * 翼搭 UI 渲染组件
     * @var string
     */
    public string $component = 'text';

    /**
     * 使用引擎，默认使用 Ant Design，若为 Amis 则使用 Amis 规则生成表单校验, Label等..
     * @var string
     */
    protected string $engine = 'ant';

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
        if (!is_null($label)) {
            $this->set('label', $label);
        }
        $this->rules = new Collection();
    }

    /**
     * 默认渲染组件
     * @param string $component
     * @return $this
     */
    public function component(string $component): self
    {
        return $this->set('component', $component);
    }

    /**
     * 默认内容
     * @param $value
     * @return $this
     */
    public function defaultValue($value): self
    {
        return $this->set('defaultValue', $value);
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
    public function fillRules(array $rules, array $messages): self
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
     * 表单引擎
     * @param string $engine
     * @return $this
     */
    public function engine(string $engine): self
    {
        return $this->set('engine', $engine);
    }

    /**
     * 附件上传
     * @param string $accept
     * @param int $max
     * @param string|null $api
     * @return $this
     */
    public function upload(string $accept = 'image/*', int $max = 1, ?string $api = null): self
    {
        $this->set('action', $api ?: \url('api/attachments/upload'));
        $this->set('max', $max);
        $this->set('accept', $accept);
        $this->set('multiple', $max > 1);
        $this->component = 'uploader';
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments): self
    {
        if (!in_array($name, $this->methods)) {
            $this->fieldProp($name, array_shift($arguments));
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
        return parent::render();
    }
}