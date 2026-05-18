<?php
namespace Edith\Admin\Events;

use Illuminate\Support\Collection;

/**
 * Class AccountRenderBefore
 * 账户设置表单前置钩子
 * @package Edith\Admin\Events
 */
class AccountRenderBefore
{
    /**
     * 标签列
     * @var Collection
     */
    public Collection $columns;

    /**
     * 基础设置表单
     * @var Collection
     */
    public Collection $fields;


    /**
     * 安全设置表单
     * @var Collection
     */
    public Collection $securities;

    /**
     * 标签
     * @var Collection
     */
    public Collection $tabs;

    /**
     *
     */
    public function __construct()
    {
        $this->columns = new Collection();
        $this->fields = new Collection();
        $this->securities = new Collection();
        $this->tabs = new Collection();
    }
}
