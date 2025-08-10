<?php
namespace Edith\Admin\Components\Traits\Fields;

use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * @method $this rowProps(array $rowProps)                   开启 grid 模式时传递给 Row, 仅在ProFormGroup, ProFormList, ProFormFieldSet 中有效 默认： {gutter: 8}
 * @method $this colProps(array $colProps)                   开启 grid 模式时传递给 Col 默认： {xs: 24}
 * @method $this tooltip(string $tooltip)                    会在 label 旁增加一个 icon，悬浮后展示配置的信息
 */
trait FieldAttribute
{
    /**
     * @return $this
     */
    public function initializeFieldAttribute(): static
    {
        return $this;
    }

    /**
     * 输入框的 id
     * @param string $id
     * @return $this
     */
    public function id(string $id): static
    {
        return $this->fieldProp('id', $id);
    }

    /**
     * 表单隐藏项
     * @param bool $hidden
     * @return $this
     */
    public function hidden(bool $hidden = true): static
    {
        return $this->formItemProp('hidden', $hidden);
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options): static
    {
        return $this->fieldProp('options', $options);
    }

    /**
     * 自动获取焦点
     * @param bool $value
     * @return $this
     */
    public function autoFocus(bool $value = true): static
    {
        return $this->fieldProp('autoFocus', $value);
    }

    /**
     * 表单项帮助提示
     * @param string|null $help
     * @return $this
     */
    public function help(?string $help): static
    {
        if (empty($help)) {
            return $this;
        }
        return $this->formItemProp('help', $help);
    }

    /**
     * 表单项帮助提示
     * @param string $content
     * @return $this
     */
    public function extra(string $content): static
    {
        return $this->formItemProp('extra', $content);
    }

    /**
     * 带有前缀图标的 input
     * @param array|object|string $value
     * @return $this
     */
    public function prefix(array|object|string $value): static
    {
        return $this->fieldProp('prefix', $value);
    }

    /**
     * 带有前缀图标的 input
     * @param array|object|string $value
     * @return $this
     */
    public function suffix(array|object|string $value): static
    {
        return $this->fieldProp('suffix', $value);
    }

    /**
     * 带标签的 input，设置后置标签
     * @param string $value
     * @return $this
     */
    public function addonAfter(string $value): static
    {
        return $this->fieldProp('addonAfter', $value);
    }

    /**
     * 带标签的 input，设置前置标签
     * @param string $value
     * @return $this
     */
    public function addonBefore(string $value): static
    {
        return $this->fieldProp('addonBefore', $value);
    }

    /**
     * 输入框内容 | 指定当前选中的条目，多选时为一个数组。（value 数组引用未变化时，Select 不会更新）
     * @param $value
     * @return $this
     */
    public function value($value): static
    {
        return $this->set('value', $value);
    }

    /**
     * 形态变体    outlined | borderless | filled | underlined
     * @param string $value
     * @return $this
     */
    public function variant(string $value): static
    {
        return $this->fieldProp('variant', $value);
    }

    /**
     * 声明 input 类型，同原生 input 标签的 type 属性，见：MDN(请直接使用 Input.TextArea 代替 type="textarea") 默认 text
     * @param string $value
     * @return $this
     */
    public function type(string $value): static
    {
        return $this->fieldProp('type', $value);
    }

    /**
     * 最大长度
     * @param int $value
     * @return $this
     */
    public function maxLength(int $value): static
    {
        return $this->fieldProp('maxLength', $value);
    }

    /**
     * 自定义大小
     * @param string|int $size
     * @return $this
     */
    public function size(string|int $size): static
    {
        return $this->fieldProp('size', $size);
    }

    /**
     * 自适应内容高度，可设置为 true | false 或对象：{ minRows: 2, maxRows: 6 } (textarea)
     * @param array|bool $size
     * @return $this
     */
    public function autoSize(array|bool $size = true): static
    {
        return $this->fieldProp('autoSize', $size);
    }

    /**
     * 表单只读设置
     * @param bool $readonly
     * @return $this
     */
    public function readonly(bool $readonly = true): static
    {
        return $this->set('readonly', $readonly);
    }

    /**
     * 支持清除，针对 LightFilter 下有效，主动设置情况下同时也会透传给 fieldProps
     * @param bool $allowClear
     * @return $this
     */
    public function allowClear(bool $allowClear = true): static
    {
        return $this->fieldProp('allowClear', $allowClear);
    }

    /**
     * 是否展示字数	boolean | { formatter: (info: { value: string, count: number, maxLength?: number }) => ReactNode }
     * @param bool|array $config
     * @return $this
     */
    public function showCount(bool|array $config = true): static
    {
        return $this->fieldProp('showCount', $config);
    }

    /**
     * 是否禁用
     * @param bool|array $disable boolean | { checkbox: boolean; }
     * @return $this
     */
    public function disabled(bool $disable = true): static
    {
        return $this->fieldProp('disabled', $disable);
    }

    /**
     * 占位提示符
     * @param string|array $placeholder
     * @return $this
     */
    public function placeholder(string|array $placeholder): static
    {
        return $this->fieldProp('placeholder', $placeholder);
    }

    /**
     * @param array|string $config
     * @return $this
     */
    public function autoFill(array|string $config): static
    {
        return $this->set('autoFill', $config);
    }

    /**
     * 设置表单必填项
     * @param array|string|null $message
     * @param array $otherRules
     * @return $this
     * @throws RendererException
     */
    public function required(string|array|null $message = null, array $otherRules = []): static
    {
        if (is_array($message)) {
            $otherRules = $message;
            $message = null;
        }
        is_null($message) && $message = ($this->title ?? '此项') . '为必填项';
        return $this->rules(array_merge([
            [
                'required' => true,
                'message' => $message
            ]
        ], $otherRules));
    }

    /**
     * @param array $rules
     * @return $this
     * @throws RendererException
     */
    public function rules(array $rules): static
    {
        foreach ($rules as $rule) {
            if (!is_array($rule)) {
                throw new RendererException('Rules should be an array');
            }
        }
        $this->formItemProp('rules', $rules);
        return $this;
    }

    /**
     * 表单的 props，会透传给表单项,如果渲染出来是 Input,就支持 input 的所有 props，同理如果是 select，也支持 select 的所有 props。也支持方法传入
     * @param string $field
     * @param object|bool|array|numeric-string $props
     * @return $this
     */
    public function fieldProp(string $field, object|bool|array|string $props): static
    {
        if (!isset($this->fieldProps)) {
            $this->fieldProps = new Collection();
        }
        $this->fieldProps->put($field, $props);
        return $this;
    }

    /**
     * 传递给 Form.Item 的配置
     * @param string $field
     * @param array|numeric-string|bool|object $formItemProps
     * @return $this|FieldAttribute
     */
    public function formItemProp(string $field, array|string|bool|object $formItemProps): static
    {
        if (!isset($this->formItemProps)) {
            $this->formItemProps = new Collection();
        }
        $this->formItemProps->put($field, $formItemProps);
        return $this;
    }
}