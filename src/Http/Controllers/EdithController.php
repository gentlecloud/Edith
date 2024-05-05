<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Card;
use Gentle\Edith\Components\Amis\Flex;
use Gentle\Edith\Components\Amis\Grid;
use Gentle\Edith\Components\Amis\Page;
use Gentle\Edith\Components\Amis\Show\Image;
use Gentle\Edith\Components\Amis\Wrapper;
use Gentle\Edith\Components\Layouts\Layout;
use Gentle\Edith\Components\Pages\PageContainer;
use Gentle\Edith\Models\EdithMenu;
use Gentle\Edith\Support\Response;
use Illuminate\Http\Request;

class EdithController extends Controller
{
    /**
     * 翼搭默认后台超管渲染后端
     * @return mixed
     */
    public function manage(Request $request)
    {
        $loginApi = config('edith.auth.redirect_to', 'edith/auth/login');
//        if (empty($request->header('Authorization'))) {
//            $headers = [
//                "X-Redirect-Engine" => $loginApi
//            ];
//            return Response::response(-1, -401, '未登录', (new Page)->body("未登录"), null, $headers, 208);
//        }
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
                (new Card())->md(5)->body(Flex::make()->items([
                    new Image('https://newly.oss-cn-shanghai.aliyuncs.com/images/%E6%B9%9B%E6%8B%93LOGO_1.jpeg'),
                    (new Wrapper)->body(config('edith.name', '翼搭（Edith）'))->className('text-2xl')
                ])->direction('column')->justify('center')),
                (new Card)->body(),
                (new Card)->body("<style>\n    .cube-box{\n        height: 300px;\n        display: flex;\n        align-items: center;\n        justify-content: center;\n    }\n  .cube {\n    width: 100px;\n    height: 100px;\n    position: relative;\n    transform-style: preserve-3d;\n    animation: rotate 10s linear infinite;\n  }\n  .cube:after {\n    content: '';\n    width: 100%;\n    height: 100%;\n    box-shadow: 0 0 50px rgba(0, 0, 0, 0.2);\n    position: absolute;\n    transform-origin: bottom;\n    transform-style: preserve-3d;\n    transform: rotateX(90deg) translateY(50px) translateZ(-50px);\n    background-color: rgba(0, 0, 0, 0.1);\n  }\n  .cube div {\n    background-color: rgba(64, 158, 255, 0.7);\n    position: absolute;\n    width: 100%;\n    height: 100%;\n    border: 1px solid rgb(27, 99, 170);\n    box-shadow: 0 0 60px rgba(64, 158, 255, 0.7);\n  }\n  .cube div:nth-child(1) {\n    transform: translateZ(-50px);\n    animation: shade 10s -5s linear infinite;\n  }\n  .cube div:nth-child(2) {\n    transform: translateZ(50px) rotateY(180deg);\n    animation: shade 10s linear infinite;\n  }\n  .cube div:nth-child(3) {\n    transform-origin: right;\n    transform: translateZ(50px) rotateY(270deg);\n    animation: shade 10s -2.5s linear infinite;\n  }\n  .cube div:nth-child(4) {\n    transform-origin: left;\n    transform: translateZ(50px) rotateY(90deg);\n    animation: shade 10s -7.5s linear infinite;\n  }\n  .cube div:nth-child(5) {\n    transform-origin: bottom;\n    transform: translateZ(50px) rotateX(90deg);\n    background-color: rgba(0, 0, 0, 0.7);\n  }\n  .cube div:nth-child(6) {\n    transform-origin: top;\n    transform: translateZ(50px) rotateX(270deg);\n  }\n\n  @keyframes rotate {\n    0% {\n      transform: rotateX(-15deg) rotateY(0deg);\n    }\n    100% {\n      transform: rotateX(-15deg) rotateY(360deg);\n    }\n  }\n  @keyframes shade {\n    50% {\n      background-color: rgba(0, 0, 0, 0.7);\n    }\n  }\n</style>\n<div class=\"cube-box\">\n    <div class=\"cube\">\n        <div></div>\n        <div></div>\n        <div></div>\n        <div></div>\n        <div></div>\n        <div></div>\n    </div>\n</div>")
            ])
        ];
        $body = (new PageContainer)->title('仪表盘')->subTitle('首页')->content($body);
        $page = Page::make()->css(['.antd-Image' => ['border' => 'none !important'], '.antd-Page' => ['background' => 'unset']])->body($body);
        return engine($page, false);
    }

    /**
     * 翼搭 UI 扩展路由菜单
     * @return mixed
     */
    public function routes()
    {
        $menus = EdithMenu::with('routes')->where('status', 1)->where('pid', 0)->select('id', 'pid', 'name', 'path', 'layout', 'status')->distinct()->get()->toArray();
        foreach ($menus as $k => $v) {
            $menus[$k]['component'] = 'Edith';
        }

        return  array_merge([
            ['pid' => 0, 'name' => '管理登录', 'path' => '/edith/auth/login', 'layout' => 0, 'status' => 1, 'component' => 'Edith'],
        ], $menus);
    }
}