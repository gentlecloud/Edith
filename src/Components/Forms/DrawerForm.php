<?php
namespace Edith\Admin\Components\Forms;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Traits\Attributes\DrawerFormAttribute;

class DrawerForm extends ProForm
{
    use DrawerFormAttribute;

    /**
     * ProForm 的 Layout 切换
     * @var string
     */
    protected string $component = 'DrawerForm';

    /**
     * @param Action|string|null $button
     */
    public function __construct(Action|string|null $button = null)
    {
        parent::__construct($button);
        $this->initFormAttribute();
    }
}