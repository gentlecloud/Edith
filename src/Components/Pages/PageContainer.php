<?php
namespace Gentle\Edith\Components\Pages;

use Gentle\Edith\Components\Renderer;

/**
 * Ant PageContainer - 页容器
 * 文档： https://procomponents.ant.design/components/page-container
 * @method $this title(string $title)                                 一级标题
 * @method $this subTitle(string $subTitle)                           二级标题
 * @method $this extraContent($extraContent)                          额外内容区，位于 content 的右侧
 * @method $this extra($extra)                                        操作区
 * @method $this content(array $content)                              内容区
 * @method $this tabList(array $tabList)                              tab 标题列表  [{key: string, tab: ReactNode}]
 * @method $this tabActiveKey(string $tabActiveKey)                   当前高亮的 tab 项
 * @method $this tabBarExtraContent(array $tabBarExtraContent)        tab bar 上额外的元素
 * @method $this header(array $header)                                PageHeader 的所有属性  https://ant.design/components/page-header-cn/
 * @method $this ghost(bool $ghost)                                   配置头部区域的背景颜色为透明 默认： false
 * @method $this fixedHeader(bool $fixedHeader)                       固定 pageHeader 的内容到顶部，如果页面内容较少，最好不要使用，会有严重的遮挡问题
 * @method $this affixProps(array $affixProps)                        固钉的配置，与 antd 完全相同
 * @method $this footer(array $footer)                                悬浮在底部的操作栏，传入一个数组，会自动加空格
 * @method $this waterMarkProps(array $waterMarkProps)                配置水印，Layout 会透传给 PageContainer，但是以 PageContainer 的配置优先
 * @method $this tabProps(array $tabProps)                            Tabs 的相关属性，只有卡片样式的页签支持新增和关闭选项。使用 closable={false} 禁止关闭
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class PageContainer extends Renderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'page-container';

    /**
     * Edith 渲染组件
     * @var string
     */
    protected string $renderer = 'edith';

    /**
     * construct PageContainer
     * @param string|null $title
     * @param string|array|null $body
     */
    public function __construct(?string $title = null, $body = null)
    {
        parent::__construct();
        !is_null($title) && $this->set('title', $title);
        !is_null($body) && $this->set('body', $body);
    }
}