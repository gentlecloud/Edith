<?php
namespace Edith\Admin\Services;

use Edith\Admin\Exceptions\ServiceException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ActionLogService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithActionLog';

    /**
     * @return Builder
     * @throws ServiceException
     */
    public function query(): Builder
    {
        return parent::query()->with('admin');
    }
}