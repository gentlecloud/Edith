<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Exceptions\DaoException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ActionLogDao extends ModelDao
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithActionLog';

    /**
     * @return Builder
     * @throws DaoException
     */
    public function query(): Builder
    {
        return parent::query()->with('admin');
    }
}