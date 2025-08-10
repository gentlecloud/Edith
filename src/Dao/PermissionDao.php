<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Models\EdithPermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PermissionDao extends ModelDao
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
     * @throws DaoException
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
     * @return mixed
     */
    public function getRoutes()
    {
        $prefix = (string) config('edith.route.prefix');
        $excepts = array_merge(config('edith.auth.excepts', []), config('edith.auth.semi_permissions', []), [
            '/',
            'up',
            'storage.local'
        ]);

        $container = new Collection();

        $routes = (new Collection(app('router')->getRoutes()))->map(function ($route) {

            return $route->action['as'] ?? $route->uri();
        });

        return $container->merge($routes)->filter(function ($item) use ($excepts) {
            return !in_array($item, $excepts);
        })->all();
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
            case 'attachments.category.index':
                $name = "附件分类列表";
                break;
            case 'attachments.category.store':
                $name = "保存附件分类";
                break;
            case 'attachments.category.update':
                $name = "更新附件分类";
                break;
            case 'attachments.category.show':
                $name = "附件分类详情";
                break;
            case 'attachments.category.destroy':
                $name = "删除附件分类";
                break;
            case 'attachments.list.index':
                $name = "附件列表";
                break;
            case 'attachments.list.destroy':
                $name = "删除附件";
                break;
            case 'attachments.attachments':
                $name = "附件空间";
                break;
            case 'attachments.upload':
                $name = "附件上传";
                break;
            case 'account.settings':
                $name = "账号设置";
                break;
            case 'account.settings.store':
                $name = "保存账号设置";
                break;
            case str_contains($as, 'index'):
                $name = $menuName . "列表";
                break;
            case str_contains($as, 'create'):
                $name = '创建' . $menuName;
                break;
            case str_contains($as, 'edit'):
                $name = '编辑' . $menuName;
                break;
            case str_contains($as, 'show'):
                $name = $menuName . '详情';
                break;
            case str_contains($as, 'sync'):
                $name = '同步' . $menuName;
                break;
            case str_contains($as, 'upload'):
                $name = "上传" . $menuName;
                break;
            case str_contains($as, 'download'):
                $name = "下载" . $menuName;
                break;
            default:
                if (in_array('POST', $route->methods) || str_contains($as, 'store')) {
                    $name = '新增创建' . $menuName;
                } else if (in_array('PUT', $route->methods) || in_array('PATCH', $route->methods) || str_contains($as, 'update')) {
                    $name = "更新" . $menuName;
                } else if (in_array('DELETE', $route->methods) || str_contains($as, 'destroy')) {
                    $name = "删除" . $menuName;
                } else {
                    $name = '获取' . $menuName;
                }
                break;
        }
        return $name;
    }
}