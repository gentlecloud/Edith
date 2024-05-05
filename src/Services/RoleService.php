<?php
namespace Gentle\Edith\Services;

use Gentle\Edith\Models\EdithRole;

class RoleService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = EdithRole::class;
}