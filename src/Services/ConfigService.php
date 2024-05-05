<?php
namespace Gentle\Edith\Services;

class ConfigService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Gentle\Edith\Models\EdithConfig';

    /**
     * @var string
     */
    protected string $orderBy = 'asc';
}