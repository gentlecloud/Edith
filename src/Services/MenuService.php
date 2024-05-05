<?php
namespace Gentle\Edith\Services;

use Illuminate\Database\Eloquent\Model;

class MenuService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Gentle\Edith\Models\EdithMenu';

    /**
     * @return array
     */
    public function builder(): array
    {
        $query = $this->query()->with('children')->where('pid', 0)->orderBy('sort', 'asc');
        if ($orderBy = \request()->input('orderBy')) {
            $query->orderBy($orderBy, request()->input('orderDir', 'asc'));
        }
        return $query->get()->toArray();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($this->getModel()->where('pid', $id)->exists()) {
            throw new \Exception('当前菜单存在子菜单，无法删除！');
        }
        return parent::destroy($id);
    }
}