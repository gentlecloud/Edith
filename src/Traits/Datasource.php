<?php
namespace Edith\Admin\Traits;

use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Dao\ModelDao;

trait Datasource
{

    /**
     * @var string|null
     */
    protected ?string $daoName = ModelDao::class;

    /**
     * 控制器关联模型
     * @var string|null
     */
    protected ?string $modelName;

    /**
     * 控制器服务层
     * @return ModelDao
     * @throws DaoException
     */
    protected function dao(): ModelDao
    {
        if (empty($this->daoName) && empty($this->modelName)) {
            throw new DaoException("当前不存在服务层或未定义模型", -30000);
        }

        $dao = new $this->daoName;
        if (!($dao instanceof ModelDao)) {
            throw new DaoException('服务模型有误', -30002);
        }
        if (!empty($this->modelName)) {
            $dao->setModel(new $this->modelName);
        }
        return $dao;
    }

    /**
     * 获取当前控制器模型数据
     * @return array
     * @throws DaoException
     */
    protected function datasource(): array
    {
        return $this->dao()->builder();
    }
}

