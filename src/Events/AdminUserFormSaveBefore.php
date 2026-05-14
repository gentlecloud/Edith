<?php
namespace Edith\Admin\Events;

use Illuminate\Support\Collection;

/**
 * Class AdminUserFormSaveBefore
 * 管理员保存后置钩子
 * @package Edith\Admin\Events
 */
class AdminUserFormSaveBefore
{
    /**
     * Request 实例
     * @var Collection
     */
    public Collection $fields;

    /**
     * 构造方法
     * FrontLoginAfter constructor.
     */
    public function __construct()
    {
        $this->fields = new Collection();
    }
}
