<?php

namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Layouts\Layout;
use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Models\EdithMenu;
use Edith\Admin\Modules\Support\Cloud;
use Edith\Admin\Support\Rsa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

final class EdithController extends Controller
{
    /**
     * Edith UI 初始化
     * @return array
     */
    public function init(Request $request)
    {
        return [
            'initPage' => null,
            'serverName' => $_SERVER['SERVER_NAME'],
            'requestDomain' => $request->httpHost(),
        ];
    }

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
     * 子应用列表
     * @param Request $request
     * @return JsonResponse
     */
    public function micro(Request $request)
    {
        if ($request->input('_load_layout')) {
            $microApps = [];
        } else {
            $microApps = [];
        }

        return success($microApps);
    }

    /**
     * @return JsonResponse
     */
    public function dockInfo()
    {
        return success([
            'code' => config('edith-site.code'),
            'domain' => config('edith-site.domain'),
            'token' => base64_encode(config('edith-site.token')),
        ]);
    }

    public function logout()
    {
        try {
            $res = (new Cloud)->post('site/logout')->toArray();
            modify_config_file('edith-site', 'token', '');
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('logout succeed.');
    }

    /**
     * 翼搭 UI 扩展路由菜单
     * @return array
     */
    public function routes()
    {
        $adminMenus = EdithMenu::with('routes')->where('status', 1)->where('parent_id', 0)->select('id', 'name', 'type', 'path', 'component', 'status')->distinct()->get()->toArray();
        foreach ($adminMenus as &$row) {
            foreach ($row['routes'] as &$item) {
                if (Str::startsWith($item['path'], '/') && $item['component'] == 'Engine') {
                    $item['path'] = Str::replaceFirst($row['path'] . '/', '', $item['path']);
                }
            }
        }

        $extra = [
            ['parent_id' => 0, 'name' => '管理登录', 'path' => '/edith/auth/login', 'status' => 1, 'component' => 'Engine']
        ];


        return [
            'layout_routes' => $adminMenus,
            'routes' => $extra,
        ];
    }
}