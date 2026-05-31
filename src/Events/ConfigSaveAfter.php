<?php
namespace Edith\Admin\Events;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class ConfigSaveAfter
{
    /**
     * @var Request
     */
    public Request $request;

    /**
     * 不更新字段
     * @var Collection
     */
    public Collection $guard;

    /**
     * 构造方法
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->guard = new Collection();
    }
}
