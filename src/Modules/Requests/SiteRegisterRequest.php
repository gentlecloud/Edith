<?php

namespace Edith\Admin\Modules\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SiteRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'domain' => ['required', 'string'],
            'code' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'token.required' => '密钥不能为空',
            'token.string' => '密钥参数有误',
            'domain.string' => '授权域名参数有误',
            'domain.required' => '授权域名不能为空',
            'code.string' => '授权ID参数有误',
            'code.required' => '授权ID不能为空',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
