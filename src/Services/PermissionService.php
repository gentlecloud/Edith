<?php
namespace Gentle\Edith\Services;

use Gentle\Edith\Models\EdithPermission;

class PermissionService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = EdithPermission::class;
}