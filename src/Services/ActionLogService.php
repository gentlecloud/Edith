<?php
namespace Gentle\Edith\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ActionLogService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Gentle\Edith\Models\EdithActionLog';

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model::query()->with('admin');
    }
}