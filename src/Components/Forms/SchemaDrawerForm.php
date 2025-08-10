<?php
namespace Edith\Admin\Components\Forms;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Traits\Attributes\DrawerFormAttribute;

/**
 * Ant drawer form 表单
 * 仅支持 schema json
 */
class SchemaDrawerForm extends SchemaForm
{
    use DrawerFormAttribute;

    /**
     * Ant ProForm 渲染类型
     * @var string
     */
    protected string $layoutType = 'DrawerForm';

    public function __construct(Action|string|null $button = null)
    {
        parent::__construct($button);
        $this->initFormAttribute();
    }
}