<?php
namespace Edith\Admin\Components\Forms;

use Edith\Admin\Components\EngineRenderer;

/**
 * Edith Login Helmet 翼搭登录页面
 * 翼搭 Ant LoginForm 组件
 * @method LoginForm logo(string $logo)                                      logo 的配置，仅支持 string url
 * @method LoginForm title(string $title)                                    标题，可以配置为空
 * @method LoginForm subTitle(string $subTitle)                              二级标题，可以配置为空
 * @method LoginForm containerStyle(array $containerStyle)                   页面容器自定义样式
 * @method LoginForm actions(array $actions)                                 自定义额外的登录功能
 * @method LoginForm activityConfig(array $activityConfig)                   活动的配置，包含 title，subTitle，action，分别代表标题，次标题和行动按钮，也可配置 style 来控制区域的样式
 * @method LoginForm loginApi(string $loginApi)                              登录后端 API | 默认留空为当前页面 API 以 POST 请求发起登录
 * @method LoginForm failedRedirect(string $failedRedirect)                  失败跳转 http(s):// or Edith Engine
 * @method LoginForm layout(string $layout)                                  默认： vertical ，可选： horizontal | vertical | inline
 * @method LoginForm initialValues(array $initialValues)                     表单初始值，如： [{"username": "admin"}]
 * @method LoginForm failedReload(string $scopeName)                         登录失败后刷新组件名称 常用于刷新图形验证码等组件
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class LoginForm extends EngineRenderer
{

    /**
     * 登录后舔砖 http(s):// or Edith Engine
     * @var string
     */
    protected string $redirect = '/dashboard/index';

    /**
     * 自定义样式
     * @var array
     */
    protected array $style = [];

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
        $this->renderer(strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '-$1', $mode)));
        $this->set('loginApi', \config('edith.auth.redirect_to', \url()->current()));
    }

    /**
     * 自定义页面背景色 不设置默认读取 Antd Theme
     * @param string $backgroundColor
     * @return $this
     */
    public function backgroundColor(string $backgroundColor)
    {
        $this->style['backgroundColor'] = $backgroundColor;
        return $this;
    }

    /**
     * 整个区域的背景图片配置，手机端不会展示
     * @param string $backgroundImageUrl
     * @return $this
     */
    public function backgroundImageUrl(string $backgroundImageUrl)
    {
        $this->style['backgroundImageUrl'] = $backgroundImageUrl;
        return $this;
    }
}