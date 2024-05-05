<?php
namespace Gentle\Edith\Events;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class AuthAfter
 * 管理用户登录后事件
 * @package Gentle\Edith\Events
 */
class AuthLoginAfter
{
    /**
     * 用户
     * @var Authenticatable
     */
    public Authenticatable $user;

    /**
     * 构造方法
     * AuthLoginBefore constructor.
     * @param Authenticatable $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
}
