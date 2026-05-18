<?php
namespace Edith\Admin\Events;

use Edith\Admin\Models\EdithAdmin;
use Illuminate\Support\Collection;

/**
 * Class AccountRenderAfter
 * 账户设置表单前置钩子
 * @package Edith\Admin\Events
 */
class AccountRenderAfter
{
    /**
     * @var EdithAdmin|array|null
     */
    public EdithAdmin|array|null $user = null;

    /**
     * @var Collection
     */
    public Collection $data;

    /**
     *
     */
    public function __construct(EdithAdmin|array|null $user = null)
    {
        $this->user = $user;
        $this->data = new Collection();
    }
}
