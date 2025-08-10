<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Exceptions\DaoException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MenuDao extends ModelDao
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithMenu';

    /**
     * @var string
     */
    protected string $orderBy = 'asc';

    /**
     * @return array
     * @throws DaoException
     */
    public function builder(): array
    {
        $query = $this->query()
            ->with('children')
            ->where('parent_id', 0)
            ->orderBy('sort', 'asc')
            ->when(\request()->input('name'), function ($query, $value) {
                $query->where('name', 'like', "%$value%");
            })
            ->when(\request()->input('path'), function ($query, $value) {
                $query->where('path', 'like', "%$value%");
            });
        $list = $query->get()->toArray();
        return ['items' => $list, 'total' => count($list)];
    }

    /**
     * 保存前置操作 保存钩子 包含新增和更新
     * @param $data
     * @param $id
     * @return void
     */
    protected function saving(&$data, $id = null)
    {
        if (isset($data['parent_id']) && is_array($data['parent_id'])) {
            $data['parent_id'] = $data['parent_id']['id'];
        }
        if (isset($data['path'])) {
            if (!Str::startsWith($data['path'], '/') && $data['parent_id'] == 0) {
                $data['path'] = '/' . ltrim($data['path'], '/');
            } else {
                $data['path'] = ltrim($data['path'], '/');
            }
        }
    }

    /**
     * @param $id
     * @return void
     * @throws DaoException
     */
    protected function deleting($id)
    {
        if ($this->getModel()->where('parent_id', $id)->exists()) {
            throw new DaoException('当前菜单存在子菜单，无法删除！');
        }
    }
}