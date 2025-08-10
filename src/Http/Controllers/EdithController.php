<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Layouts\Layout;
use Edith\Admin\Models\EdithMenu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

abstract class EdithController extends Controller
{
    /**
     * 翼搭默认后台超管渲染后端
     * @return Layout
     */
    public function manage(Request $request)
    {
        $loginApi = \config('edith.auth.redirect_to', 'edith/auth/login');
        return (new Layout)
            ->title('翼搭管理后台')
            ->authApi("edith/auth/info")
            ->loginApi($loginApi)
            ->style(['height' => '100vh'])
            ->footer([
                'style' => ['background' => 'unset']
            ]);
    }

    /**
     * 翼搭 UI 扩展路由菜单
     * @return array
     */
    public function routes()
    {
        $menus = EdithMenu::with('routes')->where('status', 1)->where('parent_id', 0)->select('id', 'name', 'type', 'path', 'layout', 'component', 'status')->distinct()->get()->toArray();
        foreach ($menus as &$row) {
            foreach ($row['routes'] as &$item) {
                if (Str::startsWith($item['path'], '/') && $item['component'] == 'Engine') {
                    $item['path'] = Str::replaceFirst($row['path'] . '/', '', $item['path']);
                }
            }
        }

        return array_merge([
            ['parent_id' => 0, 'name' => '管理登录', 'path' => '/edith/auth/login', 'layout' => 0, 'status' => 1, 'component' => 'Engine'],
        ], $menus);
    }


}