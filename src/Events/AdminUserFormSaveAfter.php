<?php
namespace Edith\Admin\Events;

use Edith\Admin\Models\EdithAdmin;
use Illuminate\Http\Request;

/**
 * Class AdminUserFormSaveAfter
 * 管理员保存前置钩子
 * @package Edith\Admin\Events
 */
class AdminUserFormSaveAfter
{
    /**
     * 用户实例
     * @var EdithAdmin
     */
    public EdithAdmin $user;

    /**
     * @var array
     */
    public array $data;

    /**
     * 构造方法
     * FrontLoginAfter constructor.
     * @param EdithAdmin $user
     * @param array $data
     */
    public function __construct(EdithAdmin $user, array $data = [])
    {
        $this->user = $user;
        $this->data = $data;
    }
}
