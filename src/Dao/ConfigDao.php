<?php
namespace Edith\Admin\Dao;

class ConfigDao extends ModelDao
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithConfig';

    /**
     * @var string
     */
    protected string $orderBy = 'asc';
}