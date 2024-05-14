<?php
namespace Edith\Admin\Services;

use Edith\Admin\Exceptions\ServiceException;
use Illuminate\Database\Eloquent\Model;

class MenuService extends ModelService
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
     * @throws ServiceException
     */
    public function builder(): array
    {
        $query = $this->query()->with('children')->where('parent_id', 0)->orderBy('sort', 'asc')->when(\request()->input('orderBy'), function ($query) {
            $query->orderBy(\request()->input('orderBy'), request()->input('orderDir', 'asc'));
        });
        return $query->get()->toArray();
    }

    /**
     * @param $id
     * @return void
     * @throws ServiceException
     */
    protected function deleting($id)
    {
        if ($this->getModel()->where('parent_id', $id)->exists()) {
            throw new ServiceException('当前菜单存在子菜单，无法删除！');
        }
    }
}