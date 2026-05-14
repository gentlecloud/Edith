<?php
namespace Edith\Admin\Events;

use Illuminate\Support\Collection;

/**
 * Class AdminUserFormRenderAfter
 * 管理员表单渲染后数据填充钩子
 * @package Edith\Admin\Events
 */
class AdminUserFormRenderAfter
{
    /**
     * @var int|null
     */
    public ?int $id;

    /**
     * @var Collection
     */
    public Collection $data;

    /**
     *
     * @param int|null $id
     */
    public function __construct(?int $id = null)
    {
        $this->id = $id;
        $this->data = new Collection();
    }
}
