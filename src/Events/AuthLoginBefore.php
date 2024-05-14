<?php
namespace Edith\Admin\Events;

use Illuminate\Http\Request;

/**
 * Class AuthBefore
 * 管理用户登录前事件
 * @package Edith\Admin\Events
 */
class AuthLoginBefore
{
    /**
     * Request 实例
     * @var \Illuminate\Http\Request
     */
    public Request $request;

    /**
     * 构造方法
     * AuthLoginBefore constructor.
     */
    public function __construct()
    {
        $this->request = \request();
    }
}
