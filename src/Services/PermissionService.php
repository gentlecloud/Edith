<?php
namespace Gentle\Edith\Services;

use Gentle\Edith\Exceptions\ServiceException;
use Gentle\Edith\Models\EdithPermission;
use Illuminate\Database\Eloquent\Builder;

class PermissionService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = EdithPermission::class;

    protected string $orderBy = 'asc';

    /**
     * 查询构造器
     * @return Builder
     * @throws ServiceException
     */
    public function query(): Builder
    {
        return parent::query()->when(request()->input('menu_id'), function ($query) {
            $query->where('menu_id', request()->input('menu_id'));
        })->when(request()->input('name'), function ($query) {
            $name = request()->input('name');
            $query->where('name', 'like', "%{$name}%")->orWhere('uri', 'like', "%{$name}%");
        });
    }

    /**
     * 解析权限名称
     * @param $route
     * @param $url
     * @param string|null $menuName
     * @return string
     */
    public function parseName($route, $url, ?string $menuName = ''): string
    {
        if (isset($route->action['as'])) {
            $as = $route->action['as'];
        } else {
            $as = $url[count($url) - 1];
        }
        $menuName = str_replace(['列表'], '', $menuName);
        switch ($as) {
            case implode('/', $url) == 'dashboard/index':
                $name = "控制台";
                break;
            case str_contains($as, 'index'):
                $name = $menuName . "列表";
                break;
            case str_contains($as, 'create'):
                $name = '新增' . $menuName;
                break;
            case str_contains($as, 'edit'):
                $name = '编辑' . $menuName;
                break;
            case str_contains($as, 'show'):
                $name = $menuName . '详情';
                break;
            case str_contains($as, 'store'):
                $name = '添加' . $menuName;
                break;
            case str_contains($as, 'update'):
                $name = '更新' . $menuName;
                break;
            case str_contains($as, 'destroy'):
                $name = '删除' . $menuName;
                break;
            case str_contains($as, 'sync'):
                $name = '同步' . $menuName;
                break;
            case str_contains($as, 'upload'):
                $name = "上传" . $menuName;
                break;
            default:
                if (in_array('POST', $route->methods)) {
                    $name = '保存' . $menuName;
                } else if (in_array('PUT', $route->methods) || in_array('PATCH', $route->methods)) {
                    $name = "更新" . $menuName;
                } else if (in_array('DELETE', $route->methods)) {
                    $name = "删除" . $menuName;
                } else {
                    $name = '获取' . $menuName;
                }
                break;
        }
        return $name;
    }
}