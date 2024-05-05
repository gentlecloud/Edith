<?php
namespace Gentle\Edith\Events;

use Illuminate\Http\Request;

/**
 * Class AuthBefore
 * 管理用户登录前事件
 * @package Gentle\Edith\Event
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
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
