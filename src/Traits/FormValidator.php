<?php
namespace Edith\Admin\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

trait FormValidator
{
    /**
     * 表单校验规则
     * @var string[]
     */
    protected array $rules = [];

    /**
     * 表单校验错误消息
     * @var string[]
     */
    protected array $messages = [];

    /**
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * 表单校验
     * @param Request $request
     * @param bool $isUpdate
     */
    protected function checkFormRules(Request $request, bool $isUpdate = false)
    {
        if (!count($this->rules)) {
            $this->handleFormValidation($request->all(), $isUpdate);
        }
        $request->validate($this->rules, $this->messages);
    }

    /**
     * @param array $data
     * @param bool $isUpdate
     * @return void
     */
    protected function handleFormValidation(array $data, bool $isUpdate = false)
    {
        $rules = [];
        $messages = [];
        foreach ($this->fields() as $field) {
            if (!isset($field->formItemProps)) {
                continue;
            }
            if ($rule = $field->formItemProps->get('rules')) {
                $current = [];
                $name = $field->dataIndex ?? $field->name;
                foreach ($rule as $ruleItem) {
                    foreach ($ruleItem as $rowKey => $rowValue) {
                        if ($rowKey == 'message') {
                            continue;
                        }
                        $curKey = $rowKey;
                        if ($rowKey != 'required') {
                            if ($isUpdate) {
                                if (!Str::startsWith($rowKey, 'update_') && isset($ruleItem['update_' . $rowKey])) {
                                    continue;
                                }
                                $curKey = Str::replace('update_', '', $rowKey);
                            } else {
                                if (Str::startsWith($rowKey, 'update_')) {
                                    continue;
                                }
                            }
                            $current[] = "{$curKey}:{$this->parseRuleData($rowValue, $data)}";
                        } else {
                            $current[] = $rowKey;
                        }
                        $messages["{$name}.{$curKey}"] = $ruleItem['message'];
                    }
                }
                $rules[$name] = implode('|', $current);
            }
        }
        $this->rules = $rules;
        $this->messages = $messages;
    }

    /**
     * 替换校验规格中的变量
     * @param string $rule
     * @param array $data
     * @return string
     */
    protected function parseRuleData(string $rule, array $data = []): string
    {
        return preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($data) {
            $key = $matches[1];
            return $data[$key] ?? $matches[0];
        }, $rule);
    }
}