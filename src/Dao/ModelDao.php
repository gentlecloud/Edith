<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Traits\ModelDatasourceTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * 模型服务层
 */
class ModelDao
{
    use ModelDatasourceTrait;

    /**
     * 当前数据库模型
     * @var Model|null
     */
    protected ?Model $model = null;

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
    public array $fill = [];

    /**
     * 不可批量更新字段
     * @var array
     */
    public array $guard = [];

    /**
     * 使用附件字段，添加后可快速资源，附件删除保护等
     * @var array
     */
    public array $attachmentFields = [];

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
     * @throws DaoException
     */
    public function getModel(): Model
    {
        if (!$this->model) {
            $className = get_called_class();
            throw new DaoException("The current {$className} layer is not configured with a model.");
        }
        return $this->model;
    }

    /***
     * 设置当前服务层模型
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model): ModelDao
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
     * @throws DaoException
     */
    public function query(): Builder
    {
        $query = $this->getModel()::query();
        if ($orderBy = \request()->input('sorter')) {
            foreach ($orderBy as $field => $direction) {
                $query->orderBy($field, $direction == 'ascend' ? 'asc' : 'desc');
            }
        } else {
            $query->orderBy('id', $this->orderBy ?: 'desc');
        }
        return $query
            ->when(\request()->input('created_at'), function ($query) {
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
     * @throws DaoException
     */
    public function builder(): array
    {
        $query = $this->query();

        $paginate = $query->paginate(\request()->input('pageSize', 50), ['*'], 'page', \request()->input('current', 1));

        if (!empty($this->attachmentFields)) {
            foreach ($paginate->items() as $item) {
                foreach ($this->attachmentFields as $field) {
                    $attachment = data_get($item, $field);
                    data_set($item, $field, get_attachment($attachment));
                }
            }
        }
        return ['items' => $paginate->items(), 'total' => $paginate->total(), 'page' => $paginate->lastPage(), 'current' => $paginate->currentPage()];
    }

    /**
     * @param $id
     * @return mixed
     * @throws DaoException
     */
    public function get($id = null)
    {
        $info = $this->getModel()->findOrFail($id ?: \request()->input('id'));
        if (!empty($this->attachmentFields)) {
            foreach ($this->attachmentFields as $field) {
                $attachment = data_get($info, $field);
                data_set($info, $field, get_attachment($attachment, \request()->header('x-edith-version') ? 'all' : 'path'));
            }
        }
        return $info;
    }

    /**
     * 保存
     * @param array $data
     * @return mixed
     * @throws DaoException
     */
    public function store(array $data)
    {
        $result = null;
        DB::transaction(function () use (&$result, $data) {
            $this->saving($data);
            $result = $this->getModel()->create($this->fillData($data));
            $this->saved($data, $result);
            $this->saveAttachment($result->getKey());
        }, 3);
        return $result;
    }

    /**
     * 默认模型更新
     * @param array $data
     * @param $id
     * @return mixed
     * @throws DaoException
     */
    public function update(array $data, $id)
    {
        DB::transaction(function () use (&$result, $data, $id) {
            $model = $this->getModel()->findOrFail($id);
            $this->saving($data, $id);
            foreach ($this->fillData($data) as $key => $value) {
                $model->setAttribute($key, $value);
            }
            $result = $model->save();
            $this->saved($data, $model);
            $this->saveAttachment($id);
        }, 3);
        return $result;
    }

    /**
     * 拖拽排序保存
     * @param array $rows
     * @return void
     * @throws DaoException
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
     * @throws DaoException
     */
    public function destroy($id)
    {
        $this->deleting($id);
        $result = $this->getModel()->destroy($id);
        $this->deleted($id);
        return $result;
    }

    /**
     * 处理搜索表单时间戳
     * @param string $field
     * @return array|null
     */
    protected function handleSearchTime(string $field = 'created_at'): ?array
    {
        $time = request()->input($field);
        if (is_string($time)) {
            $time = explode(",", $time);
        }
        if (!count($time)) {
            return null;
        }
        if (empty($time[1])) {
            $time[1] = time();
        }
        if (is_numeric($time[0])) {
            $time[0] = date('Y-m-d 00:00:00', $time[0]);
        }
        if (is_numeric($time[1])) {
            $time[1] = date('Y-m-d H:i:s', $time[1]);
        }
        return $time;
    }
}
