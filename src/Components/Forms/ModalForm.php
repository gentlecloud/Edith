<?php
namespace Edith\Admin\Components\Forms;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Traits\Attributes\ModalFormAttribute;

class ModalForm extends ProForm
{
    use ModalFormAttribute;

    /**
     * ProForm 的 Layout 切换
     * @var string
     */
    protected string $component = 'ModalForm';

    public function __construct(Action|string|null $button = null)
    {
        parent::__construct($button);
        $this->initFormAttribute();
    }
}