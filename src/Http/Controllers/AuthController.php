<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\Action;
use Gentle\Edith\Components\Amis\Action\Button;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\InputText;
use Gentle\Edith\Components\Amis\Grid;
use Gentle\Edith\Components\Amis\Page;
use Gentle\Edith\Components\Amis\Show\Image;
use Gentle\Edith\Components\Amis\Wrapper;
use Gentle\Edith\Components\Displays\Iconfont;
use Gentle\Edith\Components\Displays\Tabs;
use Gentle\Edith\Components\Fields\Field;
use Gentle\Edith\Components\Fields\ImageCaptcha;
use Gentle\Edith\Components\Layouts\Space;
use Gentle\Edith\Components\Pages\Helmet;
use Gentle\Edith\Components\Pages\LoginForm;
use Gentle\Edith\Events\AuthLoginAfter;
use Gentle\Edith\Facades\Edith;
use Gentle\Edith\Models\EdithAdmin;
use Gentle\Edith\Models\EdithMenu;
use Gentle\Edith\Models\EdithPlatform;
use Gentle\Edith\Support\GoogleAuthenticator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AuthController extends Controller
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
        'captcha.required' => '验证码不能为空',
    ];

    /**
     * 登录界面
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Gentle\Edith\Exceptions\FormValidatorException
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $page = LoginForm::make()
            ->title('翼搭')
            ->subTitle('翼搭 - 便捷快速的低代码搭建平台')
            ->logo('https://github.githubassets.com/images/modules/logos_page/Octocat.png')
            ->layout('horizontal');

        $tabs = (new Tabs)->centered()->cardProps('bodyStyle', ['paddingInline' => 0]);
        $loginForm = [
            (new InputText('mode'))->style(['display' => 'none'])->autoFill(['api' => 'edith/auth/query?username=${username}']), //
            (new Field('username'))->id('username')->placeholder('用户名')->size('large')
                ->prefix(new Iconfont('icon-shouye1'))
                ->fillRules($this->rules, $this->messages),
            (new Field('password'))->placeholder('登录密码')->component('password')->size('large')
                ->prefix(new Iconfont('icon-password'))
                ->fillRules($this->rules, $this->messages)
        ];
        if (intval(edith_config('LOGIN_CAPTCHA'))) {
            $loginForm = array_merge($loginForm, [
                (new ImageCaptcha('captcha'))
                    ->size('large')
                    ->captcha('https://newly.g8b70a.cn/api/admin/captcha')
                    ->placeholder('图形验证码')
                    ->prefix(new Iconfont('icon-password'))
                    ->visibleOn('${ mode === "captcha" }'),
                (new Field('authenticator'))->size('large')
                    ->prefix(new Iconfont('icon-password'))
                    ->placeholder('验证码')
                    ->visibleOn('${ mode === "authenticator" }')
            ]);
        }
        $tabs->tab('account', '账号密码登录')->children($loginForm);
        $tabs->tab('phone', '验证码登录')->body('暂不支持验证码登录');
        $css = [
            '.antd-Page' => ['height' => '100vh', 'overflow' => 'hidden']
        ];

        $render = (new Page)->body($page->body($tabs))->css($css);

        return engine(Helmet::make()->title('登录')->body($render), false);
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Gentle\Edith\Exceptions\FormValidatorException
     */
    public function toLogin(Request $request)
    {
        $credentials = $request->only(['username', 'password']);
        $captcha = $request->post('captcha');
        $this->checkFormRules($credentials);

        // 登录验证
        $loginResult = Auth::guard('manage')->attempt($credentials, $request->post('autoLogin', false));
        if (!$loginResult){ // 验证失败
            return $this->checkLoginFail($credentials['username']);
        }
        $user = Auth::guard('manage')->user();
        if ($user['google_open'] == 1 && !empty($user['google_secret']) && !(new GoogleAuthenticator())->verifyCode($user['google_secret'], $request->post('authenticator'))) {
            Auth::guard('manage')->logout();
            return error('验证码错误.');
        }
        $after = new AuthLoginAfter($user);
        event($after);

        $user->save();

        if ($user['id'] == config('edith.auth.admin_id', 1)) {
            $user['platforms'] = array_merge([[
                'id' => 0,
                'title' => '控制台',
                'status' => 1
            ]], EdithPlatform::select('id', 'title', 'logo', 'status')->get()->toArray());
        } else {
            $user['platforms'] = EdithPlatform::where('admin_id', $user['pid'] ?: $user['id'])->select('id', 'title', 'logo', 'status')->get()->toArray();
            if (!$user['platforms']) {
                return error('Unauthenticated.');
            }
        }
        $user['platform'] = [
            'id' => $user['platforms'][0]['id'],
            'title' => $user['platforms'][0]['title']
        ];
        $user['token'] = $user->createToken($user['platform']['id']);
        return success('登录成功', $user);
    }

    /**
     * 用户信息
     * @return mixed
     */
    public function info()
    {
        $user = auth('manage')->user()->makeHidden(['google_secret', 'google_qrcode'])->toArray();
        if (app('edith.auth')->isSuperAdministrator()) {
            $user['platforms'] = array_merge([[
                'id' => 0,
                'title' => '控制台',
                'status' => 1
            ]], EdithPlatform::select('id', 'title', 'logo', 'status')->get()->toArray());
        }
        $user['platform'] = app('edith.platform')->info() ?: [
            'id' => 0,
            'title' => '控制台'
        ];
        return $user;
    }

    /**
     * 切换平台
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function platform(Request $request)
    {
        $id = $request->post('id');
        if (!is_numeric($id)) {
            return error('参数错误');
        }
        $platform = [
            'id' => 0,
            'title' => '控制台'
        ];
        $user = auth('manage')->user();
        try {
            if (intval($id) > 0) {
                $platform = EdithPlatform::select('id', 'title', 'logo', 'status')
                    ->findOrFail($id);
            }
            if ($platform['id'] == app('edith.platform')->id()) {
                throw new \Exception('所选平台与当前一致.');
            }
            if (!in_array($platform['id'], [$user['id'], $user['pid']])) {
                throw new \Exception('权限不足.');
            }
        } catch (\Exception $e) {
            return error('切换失败：' . $e->getMessage());
        }
        return success('切换成功', ['platform' => $platform], '/dashboard/index', $user->createToken($id));
    }

    /**
     * 用户查询验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(Request $request)
    {
        $content = ['mode' => 'captcha'];
        $user = EdithAdmin::where('username', $request->input('username'))->where('status', 1)->select('id', 'username', 'status', 'google_open')->first();
        if ($user && $user['google_open']) {
            $content['mode'] = 'authenticator';
        }
        return success('ok.', $content);
    }

    /**
     * 获取管理权限菜单
     * @return mixed
     */
    public function menu()
    {
        $type = app('edith.auth')->platformId() == 0 ? 'admin' : 'platform';
        $menus = EdithMenu::where('status', 1)
            ->whereIn('guard_name', ['all', 'basic', $type])
            ->select('id', 'name', 'icon', 'guard_name', 'path', 'pid', 'sort', 'target', 'module')
            ->orderBy('sort', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        $prefix = Edith::routerPrefix();

        $list = [];
        foreach ($menus as $menu) {
//            $data[$key]['key'] = Str::uuid();
//            $data[$key]['locale'] = 'menu'. Str::replace("/", ".", $value['path']);
//            if (empty($data[$key]['icon'])) unset($data[$key]['icon']);
//            if ($value['pid'] != 0) {
//                $data[$key]['path'] = "/$prefix/{$value['path']}";
//            }
//            $data[$key]['component'] = '@/pages/Edith/index';
//            $data[$key]['layout'] = true;
//            unset($data[$key]['target']);
            $list[] = [
                'id' => $menu['id'],
                'key' => uniqid(),
                'name' => $menu['name'],
                'path' => $menu['pid'] == 0 ? $menu['path'] : (substr($menu['path'], 0, 1) === "/" ? substr($menu['path'], 1, -1) : $menu['path']),
                'icon' => $menu['icon'] ?: null,
                'component' => 'Edith',
                'pid' => $menu['pid'],
                'hideInMenu' => false
            ];
        }
        return success('query succeed.', list_to_tree($list, 'id', 'pid', 'routes'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    protected function checkLoginFail(string $username){
        if (Cache::has("manage_user_fail_{$username}")) {
            Cache::increment("manage_user_fail_{$username}");
        } else {
            Cache::put("manage_user_fail_{$username}", 1, 60*10);
        }

        return error("账号或密码错误");
    }
}