<?php
namespace Gentle\Edith\Traits;

use Gentle\Edith\Exceptions\ServiceException;
use Gentle\Edith\Services\ModelService;

trait Datasource
{

    /**
     * @var string|null
     */
    protected ?string $serviceName = ModelService::class;

    /**
     * 控制器关联模型
     * @var string|null
     */
    protected ?string $modelName;

    /**
     * 控制器服务层
     * @return ModelService
     * @throws ServiceException
     */
    protected function service(): ModelService
    {
        if (empty($this->serviceName) && empty($this->modelName)) {
            throw new ServiceException("当前不存在服务层或未定义模型", -30000);
        }

        $service = new $this->serviceName;
        if (!($service instanceof ModelService)) {
            throw new ServiceException('服务模型有误', -30002);
        }
        if (!empty($this->modelName)) {
            $service->setModel(new $this->modelName);
        }
        return $service;
    }

    /**
     * 获取当前控制器模型数据
     * @return array
     * @throws ServiceException
     */
    protected function datasource(): array
    {
        return $this->service()->builder();
    }
}

