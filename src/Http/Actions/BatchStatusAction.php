<?php
namespace Edith\Admin\Http\Actions;

use Edith\Admin\Components\Displays\Dropdown;

class BatchStatusAction extends Dropdown
{

    /**
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        parent::__construct($title ?? '批量操作');
    }
}