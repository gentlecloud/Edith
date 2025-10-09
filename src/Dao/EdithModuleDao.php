<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Exceptions\DaoException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EdithModuleDao extends ModelDao
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithMenu';

    /**
     * @var string
     */
    protected string $orderBy = 'asc';
}