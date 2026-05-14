<?php
namespace Edith\Admin\Events;

use Illuminate\Support\Collection;

/**
 * Class AdminUserFormRenderBefore
 * 管理员表单渲染钩子
 * @package Edith\Admin\Events
 */
class AdminUserFormRenderBefore
{
    /**
     * @var Collection
     */
    public Collection $columns;

    /**
     *
     */
    public function __construct()
    {
        $this->columns = new Collection();
    }
}
