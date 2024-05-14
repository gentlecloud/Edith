<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Amis\Action\Button;
use Edith\Admin\Components\Amis\Card;
use Edith\Admin\Components\Amis\Custom;
use Edith\Admin\Components\Amis\Flex;
use Edith\Admin\Components\Amis\Form\InputStatic;
use Edith\Admin\Components\Amis\Grid;
use Edith\Admin\Components\Amis\Page;
use Edith\Admin\Components\Amis\Show\Image;
use Edith\Admin\Components\Amis\Show\Link;
use Edith\Admin\Components\Amis\Wrapper;
use Edith\Admin\Components\Layouts\Layout;
use Edith\Admin\Components\Pages\PageContainer;
use Edith\Admin\Components\Pages\ProCard;
use Edith\Admin\Facades\Edith;
use Edith\Admin\Models\EdithMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class EdithController extends Controller
{
    /**
     * 翼搭默认后台超管渲染后端
     * @return mixed
     */
    public function manage(Request $request)
    {
        $loginApi = config('edith.auth.redirect_to', 'edith/auth/login');
        return (new Layout)->title('翼搭管理后台')->authApi("edith/auth/info")->loginApi($loginApi)->style(['height' => '100vh'])->footer([
            'style' => ['background' => 'unset']
        ]);
    }

    /**
     * 仪表盘
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboard()
    {
        $body = [
            (new Grid)->columns([
                (new ProCard())->body(Flex::make()->items([
                    new Image('https://newly.oss-cn-shanghai.aliyuncs.com/images/GENTLE_LOGO.jpeg'),
                    (new Wrapper)->body(config('edith.name', '翼搭（Edith）'))->className('text-2xl font-bold'),
                    (new Flex())->className('m-3')->items([
                        (new Link())->body('Github')->icon('fa-brands fa-github')->className('mx-5')->href('https://github.com/gentlecloud/Edith')->htmlTarget('_blank'),
                        (new Link())->body('湛拓科技')->className('mx-5')->href('https://www.gentle.org.cn')->htmlTarget('_blank'),
                        (new Link())->body('翼搭官网')->className('mx-5')->href('https://www.3ii.cn')->htmlTarget('_blank'),
                    ])
                ])->direction('column')->justify('center')->alignItems('center'))->md(5),
                (new ProCard())->title('系统信息')->body($this->systemInfo()),
                (new ProCard())->title('晚上好！')->body([
                    (new Custom())->html('<div id="clock" class="text-4xl"></div><div id="clock-date" class="mt-5"></div>')
                        ->onMount(<<<JS
const clock = document.getElementById('clock');
const tick = () => {
    clock.innerHTML = (new Date()).toLocaleTimeString();
    requestAnimationFrame(tick);
};
tick();

const clockDate = document.getElementById('clock-date');
clockDate.innerHTML = (new Date()).toLocaleDateString();
JS
                        )
                ]),
            ])
        ];
        $page = Page::make()->css(['.antd-Image' => ['border' => 'none !important'], '.antd-Page' => ['background' => 'unset']])->body($body);
        return engine((new PageContainer)->title('仪表盘')->subTitle('首页')->extra(
            (new Button('刷新'))->actionType('refresh')
        )->content($page), false);
    }

    /**
     * 翼搭 UI 扩展路由菜单
     * @return mixed
     */
    public function routes()
    {
        $menus = EdithMenu::with('routes')->where('status', 1)->where('parent_id', 0)->select('id', 'parent_id', 'name', 'path', 'layout', 'status')->distinct()->get()->toArray();
        foreach ($menus as $k => $v) {
            $menus[$k]['component'] = 'Edith';
        }

        return  array_merge([
            ['parent_id' => 0, 'name' => '管理登录', 'path' => '/edith/auth/login', 'layout' => 0, 'status' => 1, 'component' => 'Edith'],
        ], $menus);
    }

    protected function systemInfo()
    {
        if (str_contains(PHP_OS, "Linux")) {
            $os = "linux";
        } else if (str_contains(PHP_OS, "WIN")) {
            $os = "windows";
        } else {
            $os = PHP_OS;
        }

        return [
            (new Card())->body([
                (new InputStatic)->label('系统名称')->value(config('edith.name', '翼搭（Edith）')),
                (new InputStatic)->label('翼搭版本')->value(Edith::version()),
                (new InputStatic)->label('Laravel版本')->value(app()::VERSION),
                (new InputStatic)->label('运行环境')->value($os . ' ' . substr($_SERVER['SERVER_SOFTWARE'],0,50)),
                (new InputStatic)->label('MYSQL版本')->value(DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION)),
//            (new InputStatic)->label('上传限制')->value(ini_get('upload_max_filesize')),
            ])
        ];
    }
}