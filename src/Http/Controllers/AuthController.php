<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Forms\LoginForm;
use Edith\Admin\Components\Pages\Helmet;
use Edith\Admin\Components\Pages\Tabs;
use Edith\Admin\Events\AuthLoginAfter;
use Edith\Admin\Events\AuthLoginBefore;
use Edith\Admin\Events\FrontLoginBefore;
use Edith\Admin\Exceptions\AuthException;
use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Models\EdithAdmin as EdithAdminModel;
use Edith\Admin\Models\EdithMenu;
use Edith\Admin\Models\EdithPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class AuthController extends Controller
{
    /**
     * 登录表单校验规则
     * @var array|string[]
     */
    protected array $rules = [
        'username' => 'required|string',
        'password' => 'required|string'
    ];

    /**
     * 登录表单校验错误信息
     * @var array|string[]
     */
    protected array $messages = [
        'username.required' => '用户名不能为空',
        'username.string' => '用户名参数错误',
        'password.required' => '密码不能为空',
        'password.string' => '密码参数错误',
    ];

    /**
     * 登录界面
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Edith\Admin\Exceptions\FormValidatorException
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $renderer = new FrontLoginBefore($request);
        event($renderer);
        $page = LoginForm::make()
            ->title('翼搭')
            ->subTitle('翼搭 - 便捷快速的低代码开发平台')
            ->logo('https://newly.oss-cn-shanghai.aliyuncs.com/images/GENTLE_LOGO.jpeg')
            ->containerStyle([
                'boxSizing' => 'border-box'
            ])
            ->failedReload('image-captcha')
            ->layout('horizontal');

        $tabs = (new Tabs)->centered();
        $loginForm = $renderer->fields->toArray();
        $tabs->item('账号密码登录', 'account')->children($loginForm);

        foreach ($renderer->tabs as $tab) {
            try {
                $tabs->item($tab['title'], $tab['key'] ?? uniqid('login_tab_'))->children($tab['body']);
            } catch (\Exception $e) {
                continue;
            }
        }
        return engine((new Helmet())->title('翼搭')->body($page->body($tabs)->style(['height' => '100vh'])), false);
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Edith\Admin\Exceptions\FormValidatorException|AuthException
     */
    public function toLogin(Request $request)
    {
        $credentials = $request->only(['username', 'password']);
        try {
            $before = new AuthLoginBefore();
            event($before);
            if (!$before->user) {
                // 登录验证
                $this->checkFormRules($request);
                $credentials['status'] = 1;
                $loginResult = Auth::guard('manage')->attempt($credentials, $request->post('auto_login', false));
                if (!$loginResult) { // 验证失败
                    $this->checkLoginFail($credentials['username']);
                }
                $user = Auth::guard('manage')->user();
            } else {
                $user = $before->user;
            }

            if (!$user->isSuperAdministrator() && !count($user->roles)) {
                throw new AuthException('无权限.');
            }
            $after = new AuthLoginAfter($user);
            event($after);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('登录成功', $after->result);
    }

    /**
     * 用户信息
     * @return mixed
     */
    public function info()
    {
        $user = auth('manage')->user()->makeHidden(['google_secret', 'google_qrcode'])->toArray();
        return $user;
    }

    /**
     * 获取管理权限菜单
     * @return mixed
     */
    public function menu()
    {
        $type = app('edith.auth')->platformId() == 0 ? 'admin' : 'platform';
        $user = auth('manage')->user();
        $extra = [];
        if (!$user->isSuperAdministrator()) {
            $ids = $user->menus()->pluck('menu_id')->toArray();
            $parents = EdithMenu::where('id', $ids)->where('parent_id', '>', 0)->distinct()->pluck('parent_id')->toArray();
            $parentIds = EdithMenu::where('id', $parents)->where('parent_id', '>', 0)->distinct()->pluck('parent_id')->toArray();
            $ids = array_unique(array_merge($parents, $parentIds, $ids));
            $menus = EdithMenu::where('status', 1)
                ->whereIn('guard_name', ['basic', $type])
                ->whereIn('id', $ids)
                ->select('id', 'name', 'icon', 'guard_name', 'path', 'entry', 'parent_id', 'sort', 'type', 'module', 'component')
                ->orderBy('sort', 'asc')
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();
            $menus = list_to_tree($menus, 'id', 'parent_id', 'routes');
        } else {
            $menus = EdithMenu::with('routes')
                ->where('status', 1)
                ->where('parent_id', 0)
                ->whereIn('guard_name', ['basic', $type])
                ->when(env('EDITH_DEV') == false, function ($query) {
                    $query->where('is_dev', 0);
                })
                ->select('id', 'name', 'icon', 'guard_name', 'path', 'entry', 'parent_id', 'sort', 'type', 'module', 'component')
                ->orderBy('sort', 'asc')
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();

            $extra = [
                [
                    'id' => -888,
                    'key' => uniqid(),
                    'name' => '翼搭云',
                    'path' => '/cloud',
                    'icon' => 'icon-yunfuwuqi',
                    'component' => 'qiankun',
                    'parent_id' => 0,
                    'hideInMenu' => false,
                    'routes' => [
                        [
                            'id' => -889,
                            'component' => 'qiankun',
                            'parent_id' => -889,
                            'name' => '应用模块',
                            'hideInMenu' => false,
                            'type' => 'engine',
                            'path' => 'ieda',
                            'entry' => '/',
                            'status' => 1
                        ]
                    ]
                ]
            ];
        }

        $list = [];
        foreach ($menus as $menu) {
            foreach ($menu['routes'] as &$item) {
                if (Str::startsWith($item['path'], '/') && $item['component'] == 'Engine') {
                    $item['path'] = ltrim($item['path'], $menu['path'] . '/');
                }
                $item['hideInMenu'] = false;
                $item['key'] = md5($menu['path'] . $item['path']);
            }
            $list[] = [
                'id' => $menu['id'],
                'key' => md5($menu['path']),
                'name' => $menu['name'],
                'path' => $menu['parent_id'] == 0 ? $menu['path'] : (str_starts_with($menu['path'], "/") ? substr($menu['path'], 1, strlen($menu['path'])) : $menu['path']),
                'icon' => $menu['icon'] ?? null,
                'component' => $menu['component'] ?? null,
                'parent_id' => $menu['parent_id'],
                'hideInMenu' => false,
                'routes' => $menu['routes'],
            ];
        }
        $list = array_merge($list, $extra);
        return success('query succeed.', $list);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            Auth::guard('manage')->logout();
            app('edith.auth')->logout();
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('logout succeed.');
    }

    /**
     * 超过登录失败次数 禁止再次进行登录操作
     * @param string $username
     * @return void
     * @throws AuthException
     */
    protected function checkLoginFail(string $username): void
    {
        if (Cache::has("manage_user_fail_{$username}")) {
            Cache::increment("manage_user_fail_{$username}");
        } else {
            Cache::put("manage_user_fail_{$username}", 1, 60 * 5);
        }
        throw new AuthException('用户名或密码错误');
    }
}