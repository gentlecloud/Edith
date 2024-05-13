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
     * @var array|null 
     */
    public ?array $result = [];

    /**
     * 构造方法
     * AuthLoginBefore constructor.
     * @param Authenticatable $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
        $this->result = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nickname' => $user['nickname'],
            'email' => $user['email'],
            'avatar' => $user['avatar'],
            'status' => $user['status'],
            'lasted_at' => $user['lasted_at'],
            'created_at' => $user['created_at'],
            'token' => $user->createToken()
        ];
    }
}
