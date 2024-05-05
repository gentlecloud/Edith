<?php
namespace Gentle\Edith\Components\Amis;

/**
 * Amis Helmet 页面组件
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/page
 * @method $this title(string $title)                                     页面标题
 * @method $this subTitle(string $subTitle)                               页面副标题
 * @method $this remark(string $remark)                                   标题附近会出现一个提示图标，鼠标放上去会提示该内容。
 * @method $this bodyClassName(string $bodyClassName)                     Body dom 类名
 * @method $this aside(array $aside)                                      往页面的边栏区域加内容
 * @method $this asideMinWidth(int $asideMinWidth)                        边栏最小宽度
 * @method $this asideMaxWidth(int $asideMaxWidth)                        边栏最大宽度
 * @method $this asideClassName(string $asideClassName)                   Aside dom 类名
 * @method $this toolbar($toolbar)                                        往页面的右上角加内容，需要注意的是，当有 title 时，该区域在右上角，没有时该区域在顶部
 * @method $this css(array $css)                                          自定义 CSS 样式
 * @method $this cssVars(array $cssVars)                                  自定义 CSS 变量，请参考样式
 * @method $this mobileCSS(array $mobileCSS)                              移动端下的样式表
 * @method $this headerClassName(string $headerClassName)                 Header 区域 dom 类名
 * @method $this initApi($initApi)                                        Helmet 用来获取初始数据的 api。返回的数据可以整个 page 级别使用。
 * @method $this initFetchOn(string $initFetchOn)                         是否起始拉取 initApi, 通过表达式配置
 * @method $this messages(array $messages)
 * @method $this name(string $name)                                       组件名字，这个名字可以用来定位，用于组件通信
 * @method $this toolbarClassName(string $toolbarClassName)               Toolbar dom 类名
 * @method $this definitions($definitions)
 * @method $this interval(int $interval)                                  刷新时间(最小 1000)
 * @method $this showErrorMsg($value)                                     是否显示错误信息，默认是显示的。
 * @method $this regions(array $regions)                                  默认不设置自动感觉内容来决定要不要展示这些区域 如果配置了，以配置为主。
 * @method $this style(array $regions)                                    自定义样式
 * @method $this loadingConfig(array $loadingConfig)                      Loading
 * @method $this pullRefresh(array $pullRefresh)                          下拉刷新配置 仅手机端生效 { disabled: bool, pullingText?: string, loosingText?: string }
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Page extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'page';

    /**
     * 默认关闭错误信息提示
     * @var bool
     */
    protected bool $showErrorMsg = false;

    /**
     * construct Page
     * @param string|null $title
     */
    public function __construct(?string $title = null)
    {
        parent::__construct();
        !is_null($title) && $this->set('title', $title);
    }

    /**
     * 页面的边栏区域宽度是否可调整
     * @param bool $asideResizor
     * @return Page
     */
    public function asideResizor(bool $asideResizor = true): Page
    {
        return $this->set('asideResizor', $asideResizor);
    }

    /**
     * 用来控制边栏固定与否
     * @default true
     * @param bool $asideSticky
     * @return Page
     */
    public function asideSticky(bool $asideSticky = true): Page
    {
        return $this->set('asideSticky', $asideSticky);
    }

    /**
     * 是否起始拉取 initApi
     * @default true
     * @param bool $initFetch
     * @return Page
     */
    public function initFetch(bool $initFetch = true): Page
    {
        return $this->set('initFetch', $initFetch);
    }

    /**
     * 配置刷新时是否显示加载动画
     * @default false
     * @param bool $silentPolling
     * @return Page
     */
    public function silentPolling(bool $silentPolling = true): Page
    {
        return $this->set('silentPolling', $silentPolling);
    }
}