<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\AjaxAction;
use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\TreeSelect;
use Gentle\Edith\Models\EdithMenu;
use Gentle\Edith\Models\EdithPermission;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '权限';

    /**
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\PermissionService";

    /**
     * 生成 Crud 列表页面
     * @param Crud $crud
     * @return Crud
     * @throws \Exception
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('id', '序号')->width(60);
        $crud->column('menu_name', '菜单名称');
        $crud->column('name', '权限名称');
        $crud->column('uri', '权限路由');
        $crud->column('created_at', '同步时间');
        $crud->column('updated_at', '更新时间')->toggled();

        $crud->operation()->rowOnlyEditDestroyAction($this->controls());
        $sync = (new AjaxAction('auth/permission/sync'))
            ->icon('fa fa-refresh')
            ->confirmText('是否要同步权限信息，该操作会在 截断权限表&权限菜单关联表 后重新生成, 是否继续操作 ?')
            ->label('自动生成')
            ->level('primary');

        $menus = EdithMenu::whereIn('guard_name', ['all', 'basic', 'admin', 'platform'])->where('parent_id', 0)->select('id as value', 'name as label', 'parent_id')->get()->toArray();
        foreach ($menus as $k => $v) {
            $menus[$k]['children'] = EdithMenu::where('parent_id', $v['value'])->select('id as value', 'name as label', 'parent_id')->get();
        }

        $crud->filter([
            (new TreeSelect('menu_id', '菜单'))->searchable()->options($menus)->size('md'),
            (new FormItem('name', '权限名称|权限路由'))->size('md')
        ]);
        return $crud->onlyBulkDeleteAction()->basicHeaderToolbar($sync);
    }

    public function controls(): array
    {
        $menus = EdithMenu::whereIn('guard_name', ['all', 'basic', 'admin', 'platform'])->where('parent_id', 0)->select('id as value', 'name as label', 'parent_id')->get()->toArray();
        foreach ($menus as $k => $v) {
            $menus[$k]['children'] = EdithMenu::where('parent_id', $v['value'])->select('id as value', 'name as label', 'parent_id')->get();
        }

        return [
            (new TreeSelect('menu_id', '所属菜单'))->searchable()->options($menus),
            (new FormItem('name', '权限名称'))->required()
        ];
    }

    /**
     * 同步路由生成权限
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync()
    {
        $routes = Route::getRoutes();
        $excepts = array_merge(config('edith.auth.excepts', []), config('edith.auth.semi_permissions', []));
        $permissions = [];
        $ids = [];
        foreach ($routes as $route) {
            if (in_array($route->uri, $excepts) || !str_contains($route->uri, 'api')) {
                continue;
            }
            $uri = str_replace($route->action['prefix'], '', $route->uri);
            if (str_starts_with($uri, '/')) {
                $uri = substr($uri, 1, strlen($uri));
            }
            $url = explode('/', $uri);
            $prefix = $route->action['prefix'];
            if (str_starts_with($prefix, 'api')) {
                $prefix = substr($route->action['prefix'], 3, strlen($route->action['prefix']));
            }
            if (!$prefix) {
                $prefix = "/" . $url[0];
            }
            $permissions[] = $route;
            $parent = EdithMenu::whereIn('guard_name', ['all', 'basic', 'admin', 'platform'])->where('path', $prefix)->first();
            if (!$parent) {
                continue;
            }
            $menu = EdithMenu::where('parent_id', $parent['id'])->where(function ($query) use ($url, $uri, $prefix) {
                $query->where('path', str_starts_with("/{$url[0]}", $prefix) ? $url[1] : $url[0])->orWhere('path', str_replace($url[0] . '/', '', $uri));
            })->first();

            $permission = EdithPermission::where('uri', $route->action['as'] ?? $route->uri)->first();
            if ($permission) {
                $ids[] = $permission['id'];
            } else {
                $res = EdithPermission::create([
                    'uri' => $route->action['as'] ?? $route->uri,
                    'menu_id' => $menu['id'] ?? $parent['id'],
                    'name' => $this->service()->parseName($route, $url, $menu['name'] ?? $parent['name']),
                ]);
                $ids[] = $res->id;
            }
        }
        EdithPermission::whereNotIn('id', $ids)->delete();
        return success('同步成功', $permissions);
    }
}