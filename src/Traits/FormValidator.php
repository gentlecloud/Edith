<?php
namespace Edith\Admin\Traits;

use Edith\Admin\Exceptions\FormValidatorException;
use Illuminate\Support\Facades\Validator;

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
     * 表单校验
     * @param array $data 提交表单
     * @throws FormValidatorException
     */
    protected function checkFormRules(array $data)
    {
        $validator = Validator::make($data, $this->rules, $this->messages);
        if ($validator->fails()) {
            throw new FormValidatorException($validator->errors()->first(), -1);
        }
    }
}