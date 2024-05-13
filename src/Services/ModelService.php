<?php
namespace Gentle\Edith\Services;

use Gentle\Edith\Exceptions\ServiceException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 模型服务层
 */
class ModelService
{
    /**
     * 当前数据库模型
     * @var Model|null
     */
    protected ?Model $model;

    /**
     * 当前数据库模型名称
     * @var string|null
     */
    protected ?string $modelName;

    /**
     * 初始化表单值
     * @var array|null
     */
    protected ?array $initialValues;

    /**
     * 排序模型字段名
     * @var string
     */
    protected string $orderField = 'sort';

    /**
     * @var string
     */
    protected string $orderBy = 'desc';

    /**
     * 可批量更新字段 留空时则不限制
     * @var array
     */
    protected array $fill = [];

    /**
     * 不可批量更新字段
     * @var array
     */
    protected array $guard = [];

    /**
     * Construct model service
     */
    public function __construct()
    {
        if (isset($this->modelName)) {
            $this->model = new $this->modelName;
        }
    }

    /**
     * @return Model
     * @throws ServiceException
     */
    public function getModel(): Model
    {
        if (!$this->model) {
            throw new ServiceException('The current service layer is not configured with a model.');
        }
        return $this->model;
    }

    /***
     * 设置当前服务层模型
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model): ModelService
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getInitialValues(): ?array
    {
        return $this->initialValues ?? [];
    }

    /**
     * @return Builder
     * @throws ServiceException
     */
    public function query(): Builder
    {
        if (!$this->model) {
            throw new ServiceException('The current service layer is not configured with a model.');
        }
        $query = $this->model::query();
        if ($orderBy = \request()->input('orderBy')) {
            $query->orderBy($orderBy, \request()->input('orderDir', 'asc'));
        } else {
            $query->orderBy('id', $this->orderBy ?: 'desc');
        }
        return $query->when(\request()->input('created_at'), function ($query) {
            $time = $this->handleSearchTime();
            $query->whereBetween('created_at', $time);
        })->when(\request()->input('updated_at'), function ($query) {
            $time = $this->handleSearchTime('updated_at');
            $query->whereBetween('updated_at', $time);
        })->when(\request()->input('deleted_at'), function ($query) {
            $time = $this->handleSearchTime('deleted_at');
            $query->whereBetween('deleted_at', $time);
        });
    }

    /**
     * @return array
     * @throws ServiceException
     */
    public function builder(): array
    {
        $query = $this->query();

        $paginate = $query->paginate(\request()->input('perPage', 20));
        return ['items' => $paginate->items(), 'total' => $paginate->total()];
    }

    /**
     * @param $id
     * @return mixed
     * @throws ServiceException
     */
    public function get($id = null)
    {
        return $this->getModel()->findOrFail($id ?: \request()->input('id'));
    }

    /**
     * 保存
     * @param $data
     * @return mixed
     * @throws ServiceException
     */
    public function store($data)
    {
        $result = null;
        DB::transaction(function () use (&$result, $data) {
            $this->saving($data);
            $result = $this->getModel()->create($this->fillData($data));
            $this->saved($data, $result->id);
        }, 3);
        return $result;
    }

    /**
     * 默认模型更新
     * @param $data
     * @param $id
     * @return mixed
     * @throws ServiceException
     */
    public function update($data, $id)
    {
        DB::transaction(function () use (&$result, $data, $id) {
            $model = $this->getModel()->findOrFail($id);
            $this->saving($data, $id);
            foreach ($this->fillData($data) as $key => $value) {
                $model->setAttribute($key, $value);
            }
            $result = $model->save();
            $this->saved($data, $id);
        }, 3);
        return $result;
    }

    /**
     * 拖拽排序保存
     * @param array $rows
     * @return void
     * @throws ServiceException
     */
    public function saveOrder(array $rows)
    {
        $order = 0;
        foreach ($rows as $row) {
            $this->update([$this->orderField => $order], $row['id']);
            $sub = 0;
            if (isset($row['children'])) {
                foreach ($row['children'] as $item) {
                    if (!isset($item['id'])) {
                        continue;
                    }
                    $this->update([$this->orderField => $sub], $item['id']);
                    $sub++;
                }
            }
            $order += 2;
        }
    }

    /**
     * 默认模型删除
     * @param $id
     * @return mixed
     * @throws ServiceException
     */
    public function destroy($id)
    {
        $this->deleting($id);
        $result = $this->getModel()->destroy($id);
        $this->deleted($id);
        return $result;
    }

    /**
     * 保存前置操作 保存钩子 包含新增和更新
     * @param $data
     * @param $id
     * @return void
     */
    protected function saving(&$data, $id = null)
    {

    }

    /**
     * 保存后置操作 保存钩子 包含新增和更新
     * @param array $data
     * @param $id
     * @return void
     */
    protected function saved($data, $id = null)
    {

    }

    /**
     * 删除前置操作 删除钩子
     * @param $id
     * @return void
     */
    protected function deleting($id)
    {

    }

    /**
     * 删除后置操作 删除钩子
     * @param $id
     * @return void
     */
    protected function deleted($id)
    {

    }

    /**
     * 填充模型数据
     * @param array $data
     * @return array
     */
    protected function fillData(array $data): array
    {
        if (count($this->fill) > 0) {
            $data = \request()->only($this->fill);
        }
        if (count($this->guard) > 0) {
            foreach ($this->guard as $item) {
                unset($data[$item]);
            }
        }
        return $data;
    }

    /**
     * 处理搜索表单时间戳
     * @param string $field
     * @return array|null
     */
    protected function handleSearchTime(string $field = 'created_at'): ?array
    {
        $time = explode(",", request()->input($field));
        if (!count($time)) {
            return null;
        }
        if (empty($time[1])) {
            $time[1] = time();
        }

        return [date('Y-m-d 00:00:00', $time[0]), date('Y-m-d H:i:s', $time[1])];
    }
}