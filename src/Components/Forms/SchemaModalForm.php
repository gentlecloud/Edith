<?php
namespace Edith\Admin\Components\Forms;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Traits\Attributes\ModalFormAttribute;

/**
 * ant modal form 表单
 * 当前仅支持 schema json 表单
 */
class SchemaModalForm extends SchemaForm
{
    use ModalFormAttribute;

    /**
     * ant proform 渲染类型
     * @var string
     */
    protected string $layoutType = 'ModalForm';

    /**
     * @param Action|string|null $button
     */
    public function __construct(Action|string|null $button = null)
    {
        parent::__construct($button);
        $this->initFormAttribute();
    }
}