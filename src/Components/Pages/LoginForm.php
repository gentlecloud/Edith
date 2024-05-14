<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\Renderer;

/**
 * Edith Login Helmet 翼搭登录页面
 * 翼搭 Ant LoginForm 组件
 * @method LoginForm logo(string $logo)                                      logo 的配置，仅支持 string url
 * @method LoginForm title(string $title)                                    标题，可以配置为空
 * @method LoginForm subTitle(string $subTitle)                              二级标题，可以配置为空
 * @method LoginForm backgroundImageUrl(string $backgroundImageUrl)          整个区域的背景图片配置，手机端不会展示
 * @method LoginForm backgroundColor(string $backgroundColor)                页面背景色
 * @method LoginForm actions(array $actions)                                 自定义额外的登录功能
 * @method LoginForm activityConfig(array $activityConfig)                   活动的配置，包含 title，subTitle，action，分别代表标题，次标题和行动按钮，也可配置 style 来控制区域的样式
 * @method LoginForm loginApi(string $loginApi)                              登录后端 API | 默认留空为当前页面 API 以 POST 请求发起登录
 * @method LoginForm failedRedirect(string $failedRedirect)                  失败跳转 http(s):// or Edith Engine
 * @method LoginForm layout(string $layout)                                  默认： vertical ，可选： horizontal | vertical | inline
 * @method LoginForm initialValues(array $initialValues)                     表单初始值，如： [{"username": "admin"}]
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class LoginForm extends Renderer
{
    /**
     * 页面背景色
     * @var string
     * @default white
     */
    protected string $backgroundColor = "white";

    /**
     * 整个区域的背景图片配置，手机端不会展示
     * @var string|null
     */
    protected ?string $backgroundImage;

    /**
     * 登录后舔砖 http(s):// or Edith Engine
     * @var string
     */
    protected string $redirect = '/dashboard/index';

    /**
     * construct LoginForm page.
     * @param string $mode loginForm|loginFormPage
     */
    public function __construct(string $mode = 'loginForm')
    {
        parent::__construct();
        if (!in_array($mode, ['loginForm', 'loginFormPage'])) {
            $mode = 'loginForm';
        }
        $this->type = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '-$1', $mode));
        $this->set('loginApi', config('edith.auth.redirect_to', url()->current()));
    }
}