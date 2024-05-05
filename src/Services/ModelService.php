<?php
namespace Gentle\Edith\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
     * @throws \Exception
     */
    public function getModel(): Model
    {
        if (!$this->model) {
            throw new \Exception('The current service layer is not configured with a model.');
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
     * @throws \Exception
     */
    public function query(): Builder
    {
        if (!$this->model) {
            throw new \Exception('The current service layer is not configured with a model.');
        }
        return $this->model::query();
    }

    /**
     * @return array
     */
    public function builder(): array
    {
        $query = $this->query();
        if ($orderBy = \request()->input('orderBy')) {
            $query->orderBy($orderBy, \request()->input('orderDir', 'asc'));
        } else {
            $query->orderBy('id', $this->orderBy ?: 'desc');
        }
        $paginate = $query->paginate(\request()->input('perPage', 20));
        return ['items' => $paginate->items(), 'total' => $paginate->total()];
    }

    /**
     * @param int|null $id
     * @return mixed
     */
    public function get(?int $id = null)
    {
        return $this->query()->findOrFail($id ?: \request()->input('id'))->toArray();
    }

    /**
     * 保存
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        return $this->getModel()->create($this->fillData($data));
    }

    /**
     * 默认模型更新
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $model = $this->getModel()->findOrFail($id);
        foreach ($this->fillData($data) as $key => $value) {
            $model->setAttribute($key, $value);
        }
        return $model->save();
    }

    /**
     * 拖拽排序保存
     * @param array $rows
     * @return void
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
     */
    public function destroy($id)
    {
        if (str_contains($id, ',')) {
            $id = explode(',', $id);
        }
        return $this->getModel()->destroy($id);
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