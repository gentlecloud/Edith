<?php
namespace Edith\Admin\Components\Layouts;

use Edith\Admin\Components\EngineRenderer;

/**
 * Ant ProLayout
 * 翼搭 Ant Layout 组件
 * @method $this cache(bool $cache)                                  Basic Layout Cache
 * @method $this title(string $title)                                layout 的左上角 的 title
 * @method $this logo(string $logo)                                  layout 的左上角 logo 的 url
 * @method $this location(string $location)                          当前位置路由
 * @method $this headerActions(array $headerActions)                 layout 的头部行为
 * @method $this contentStyle(array $contentStyle)                   layout 的内容区 style
 * @method $this primaryColor(string $primaryColor)                  layout 的主题色
 * @method $this iconfontUrl(string $iconfontUrl)                    使用 IconFont 的图标配置
 * @method $this locale(string $locale)                              当前 layout 的语言设置
 * @method $this siderWidth(int $siderWidth)                         侧边菜单宽度
 * @method $this defaultCollapsed(bool $defaultCollapsed)            是否默认展开菜单
 * @method $this waterMarkProps(array $waterMarkProps)               layout 页面水印设置
 * @method $this footer(array $footer)                               自定义页脚 { links: [{key: 'test', title: 'layout', href: 'www.alipay.com'}], copyright: 'Gentle 2022' }
 * @method $this authApi(string $authApi)                            登陆鉴权获取用户信息 API 链接
 * @method $this loginApi(string $loginApi)                          跳转登录链接
 * @method $this menuApi(string $menuApi)                            Layout 菜单获取 API
 * @method $this accountApi(string $accountApi)                      Layout 个人设置 API
 * @method $this token(array $token)                                 Pro Token 自定义设置
 * @method $this debug(bool $debug)                                  开启调试模式
 * @method $this redirect(string $redirect)                          定义重定向页面路径
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Layout extends EngineRenderer
{

    /**
     * Edith 渲染组件
     * @var string
     */
    protected string $renderer = 'layout';

    /**
     * layout 的菜单模式, side：右侧导航，top：顶部导航
     * @var string
     */
    protected string $layout = 'mix';

    /**
     * layout 的内容模式, Fluid：定宽 1200px，Fixed：自适应
     * @var string
     */
    protected string $contentWidth = 'Fluid';

    /**
     * 导航的主题，'light' | 'realDark'
     * @var string
     */
    protected string $navTheme = 'light';

    /**
     * MIX 模式下 顶部导航主题
     * @var string
     */
    protected string $headerTheme = 'dark';

    /**
     * 主题色
     * @var string
     */
    protected string $primaryColor = '#1890ff';

    /**
     * 当前 layout 的语言设置，'zh-CN' | 'zh-TW' | 'en-US'
     * @var string
     */
    protected string $locale = 'zh-CN';

    /**
     * 是否默认展开菜单
     * @var bool
     */
    protected bool $defaultCollapsed = true;

    /**
     * 禁止自动切换到移动页面 默认不开启
     * @var bool
     */
    protected bool $disableMobile = false;

    /**
     * MIX 模式下自动切割菜单
     * @var bool
     */
    protected bool $splitMenus = false;

    /**
     * 是否固定导航
     * @var bool
     */
    protected bool $fixSiderbar = true;

    /**
     * 暗黑模式
     * @var bool
     */
    protected bool $dark = true;

    /**
     * Layout 菜单 API
     * @var string
     */
    protected string $menuApi = 'edith/auth/menu';

    /**
     * @var string
     */
    protected string $accountApi = 'account/settings';

    /**
     * 重定向加载页面
     * @var string
     */
    protected string $redirect = '/dashboard/index';

    /**
     * 定义内容区样式
     * @var array|string[]
     */
    protected array $contentStyle = [
        'minHeight' => 'auto'
    ];

    /**
     * 调试模式
     * @var bool
     */
    protected bool $debug = false;

    /**
     * construct Layout
     */
    public function __construct()
    {
        parent::__construct();
        $this->debug = env('APP_DEBUG', false);
    }

    /**
     * 设置 Antd Layout 菜单模式
     * @param string $layout 支持： side | top | mix 可参考 Ant 文档
     * @return Layout
     * @throws \Exception
     */
    public function layout(string $layout): Layout
    {
        if (!in_array($layout, ['side', 'top', 'mix'])) {
            throw new \Exception("Layout only supports setting 'side', 'top' and 'mix'");
        }
        $this->layout = $layout;
        return $this;
    }

    /**
     * layout 的内容模式,Fluid：定宽 1200px，Fixed：自适应
     * @param string $mode Fluid | Fixed
     * @return Layout
     * @throws \Exception
     */
    public function contentWidth(string $mode): Layout
    {
        if (!in_array($mode, ['Fluid', 'Fixed'])) {
            throw new \Exception("Only setting 'Fluid' and 'Fixed' is supported");
        }
        $this->contentWidth = $mode;
        return $this;
    }

    /**
     * 导航的主题
     * @param string $theme realDark | light
     * @return Layout
     * @throws \Exception
     */
    public function navTheme(string $theme): Layout
    {
        if (!in_array($theme, ['light', 'realDark'])) {
            throw new \Exception("NavTheme only supports setting 'light' or 'realDark'");
        }
        $this->navTheme = $theme;
        return $this;
    }

    /**
     * MIX 模式下 顶部导航主题
     * @param string $headerTheme dark | light
     * @return Layout
     * @throws \Exception
     */
    public function headerTheme(string $headerTheme): Layout
    {
        if (!in_array($headerTheme, ['light', 'dark'])) {
            throw new \Exception("headerTheme only supports setting 'light' and 'dark'");
        }
        $this->headerTheme = $headerTheme;
        return $this;
    }

    /**
     * 自动分割菜单   仅在MIX模式下有效
     * @param bool $splitMenus
     * @return Layout
     */
    public function splitMenus(bool $splitMenus = true): Layout
    {
        return $this->set('splitMenus', $splitMenus);
    }

    /**
     * 是否固定 header 到顶部
     * @param bool $fixedHeader
     * @return Layout
     */
    public function fixedHeader(bool $fixedHeader = true): Layout
    {
        return $this->set('fixedHeader', $fixedHeader);
    }

    /**
     * 是否固定导航
     * @param bool $fixSiderbar
     * @return Layout
     */
    public function fixSiderbar(bool $fixSiderbar = true): Layout
    {
        return $this->set('fixSiderbar', $fixSiderbar);
    }

    /**
     * 是否暗黑模式
     * @param bool $dark
     * @return Layout
     */
    public function dark(bool $dark = true): Layout
    {
        return $this->set('dark', $dark);
    }

    /**
     * 禁止自动切换到移动页面 默认不开启
     * @param bool $disableMobile
     * @return Layout
     */
    public function disableMobile(bool $disableMobile = true): Layout
    {
        return $this->set('disableMobile', $disableMobile);
    }
}