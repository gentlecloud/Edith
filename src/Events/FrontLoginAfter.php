<?php
namespace Edith\Admin\Events;

use Illuminate\Http\Request;

/**
 * Class FrontLoginAfter
 * 前端中后台登录前
 * @package Edith\Admin\Events
 */
class FrontLoginAfter
{
    /**
     * Request 实例
     * @var \Illuminate\Http\Request
     */
    public Request $request;

    /**
     * 构造方法
     * FrontLoginAfter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
