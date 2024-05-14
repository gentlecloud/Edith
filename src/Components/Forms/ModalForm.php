<?php
namespace Edith\Admin\Components\Forms;

/**
 * ant modal form 表单
 * 当前仅支持 schema json 表单
 */
class ModalForm extends SchemaForm
{
    /**
     * ant proform 渲染类型
     * @var string
     */
    protected string $layoutType = 'ModalForm';
}