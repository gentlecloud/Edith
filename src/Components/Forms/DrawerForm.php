<?php
namespace Edith\Admin\Components\Forms;

/**
 * Ant drawer form 表单
 * 仅支持 schema json
 */
class DrawerForm extends SchemaForm
{
    /**
     * Ant ProForm 渲染类型
     * @var string
     */
    protected string $layoutType = 'DrawerForm';
}