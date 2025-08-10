<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Actions\Action;
use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Components\Tables\Toolbar;
use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Http\Actions\CreateSchemaModalAction;
use Edith\Admin\Models\EdithMenu;
use Edith\Admin\Models\EdithPermission;
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
    protected ?string $daoName = "Edith\Admin\Dao\PermissionDao";

    /**
     * 生成 Crud 列表页面
     * @param Table $table
     * @return Table
     * @throws \Exception
     */
    public function table(Table $table): Table
    {
        $table->column('id', '序号')->width(60)->hideInSearch();
        $table->column('menu_name', '菜单名称');
        $table->column('name', '权限名称')->editable();
        $table->column('uri', '权限路由');
        $table->column('created_at', '创建时间')->hideInSearch();
        $table->column('updated_at', '更新时间')->hideInSearch();

        $table->operation()->rowOnlyEditDestroyAction($this->fields(), $this->title, 'modal');
        $sync = (new Action('自动生成'))
            ->actionType('ajax')
            ->api('post:auth/permission/sync')
            ->reload('pro-table')
            ->icon('icon-tongbu')
            ->withConfirm('生成权限菜单', '是否要同步权限信息，该操作会在 截断权限表&权限菜单关联表 后重新生成, 是否继续操作 ?')
            ->variant('outlined')
            ->color('primary');

        $table->toolbar(function (Toolbar $toolbar) use ($sync) {
            $toolbar->actions([
                $sync,
                new CreateSchemaModalAction('添加权限', $this->fields())
            ]);
        });

        $menus = EdithMenu::whereIn('guard_name', ['all', 'basic', 'admin', 'platform'])->where('parent_id', 0)->select('id as value', 'name as label', 'parent_id')->get()->toArray();
        foreach ($menus as $k => $v) {
            $menus[$k]['children'] = EdithMenu::where('parent_id', $v['value'])->select('id as value', 'name as label', 'parent_id')->get();
        }
        return $table->headerTitle('权限列表')->initQuickSaveItemApi();
    }

    /**
     * @return array
     * @throws DaoException
     * @throws RendererException
     */
    public function fields(): array
    {
        $menus = EdithMenu::whereIn('guard_name', ['all', 'basic', 'admin', 'platform'])->where('parent_id', 0)->select('id as value', 'name as label', 'parent_id')->get()->toArray();
        foreach ($menus as $k => $v) {
            $menus[$k]['children'] = EdithMenu::where('parent_id', $v['value'])->select('id as value', 'name as label', 'parent_id')->get();
        }

        return [
            (new Column('menu_id', '所属菜单'))
                ->valueType('treeSelect')
                ->options($menus)
                ->required()
                ->fieldProp('treeDefaultExpandAll', true),
            (new Column('name', '权限名称'))->required([
                [
                    'unique' => 'edith_permissions,name',
                    'update_unique' => 'edith_permissions,name,{id}',
                    'message' => '权限名称已存在'
                ]
            ]),
            (new Column('uri', '权限路由'))
                ->required([
                    [
                        'unique' => 'edith_permissions,uri',
                        'update_unique' => 'edith_permissions,uri,{id}',
                        'message' => '权限路由已存在'
                    ]
                ])
                ->valueType('select')
                ->valueEnum($this->dao()->getRoutes()),
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
        try {
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
                        'name' => $this->dao()->parseName($route, $url, $menu['name'] ?? $parent['name']),
                    ]);
                    $ids[] = $res->id;
                }
            }
            EdithPermission::whereNotIn('id', $ids)->delete();
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('同步成功', $permissions);
    }
}