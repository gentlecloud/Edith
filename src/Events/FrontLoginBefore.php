<?php
namespace Edith\Admin\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class FrontLoginBefore
 * 前端中后台登录前
 * @package Edith\Admin\Events
 */
class FrontLoginBefore
{
    /**
     * Request 实例
     * @var \Illuminate\Http\Request
     */
    public Request $request;

    /**
     * 登录表单
     * @var Collection
     */
    public Collection $fields;

    /**
     * 登录 tab 页
     * @var Collection
     */
    public Collection $tabs;

    /**
     * 构造方法
     * FrontLoginBefore constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->fields = new Collection();
        $this->tabs = new Collection();
    }
}
