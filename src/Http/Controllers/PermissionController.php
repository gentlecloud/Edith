<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\AjaxAction;
use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\FormItem;
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
        $crud->column('uri', '权限路由');
        $crud->column('methods', '操作方式');
        $crud->column('created_at', '同步时间');
        $crud->column('updated_at', '更新时间');

        $crud->operation()->rowOnlyDestroyAction();
        $sync = (new AjaxAction('auth/permission/sync'))
            ->icon('fa fa-refresh')
            ->confirmText('是否要同步权限信息，该操作会在 截断权限表&权限菜单关联表 后重新生成, 是否继续操作 ?')
            ->label('同步')
            ->level('primary');

        return $crud->onlyBulkDeleteAction()->headerToolbar($sync);
    }

    public function controls(): array
    {
        return [
            (new FormItem('name', '权限名称')),

        ];
    }

    public function sync()
    {
        $routes = Route::getRoutes();
        $excepts = array_merge(config('edith.auth.excepts', []), config('edith.auth.semi_permissions', []));
        $permissions = [];
        foreach ($routes as $route) {
            if (in_array($route->uri, $excepts) || strpos($route->uri, 'api') === false)
                continue;
            $permissions[] = $route->uri;
        }
        return success('同步成功', $permissions);
    }
}