<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Layouts\Layout;
use Edith\Admin\Models\EdithMenu;
use Edith\Admin\Support\Cloud;
use Edith\Admin\Support\Rsa;
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
     * 子应用列表
     * @param Request $request
     * @return JsonResponse
     */
    public function micro(Request $request)
    {
        if ($request->input('layout')) {
            $microApps = [
                [
                    'name' => 'EdithCloud',
                    'entry' => 'http://10.0.0.8:8080', // 远程子应用地址，不需要和主应用在同一项目
                    'container' => '#subapp-layout-container',
                    'activeRule' => '/cloud/ieda',
                ]
            ];
        } else {
            $microApps = [];
        }

        return success($microApps);
    }

    public function register(Request $request)
    {
        $data = $request->only(['code', 'is_dev', 'domain']);
        if (empty($data['code'])) {
            return error('参数错误.');
        }
        try {
            $rsaInfo = (new Rsa())->generate();
            $res = (new Cloud())->postJson('site/register', [
                'domain' => $data['domain'] ?? $request->header('host'),
                'code' => $data['code'],
                'public_key' => $rsaInfo['public_key'],
            ])->toArray();
            $str = "<?php\r\n/**\r\n * Edith-Cloud-Site \r\n */\r\nreturn [\r\n";
            foreach ($data as $key => $value) {
                $str .= "\t'$key' => '$value',\r\n";
            }
            $str .= "\t'private_key' => '" . $rsaInfo['private_key'] . "',\r\n";
            $str .= '];';
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        @file_put_contents(base_path('config/edith-site.php'), $str);
        return success();
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

        $clouds = [
            ['id' => -889, 'parent_id' => -888, 'name' => '应用模块', 'path' => 'ieda', 'entry' => 'http://localhost:8080', 'layout' => 1, 'status' => 1, 'component' => 'Qiankun'],
        ];

        return array_merge([
            ['parent_id' => 0, 'name' => '管理登录', 'path' => '/edith/auth/login', 'layout' => 0, 'status' => 1, 'component' => 'Engine'],
            ['id' => -888, 'parent_id' => 0, 'name' => '翼搭云服务', 'path' => '/cloud', 'layout' => 1, 'status' => 1, 'component' => 'Qiankun', 'routes' => $clouds],
            ['parent_id' => 0, 'name' => '主页', 'path' => '/', 'layout' => 0, 'status' => 1, 'component' => 'Home'],
        ], $menus);
    }


}