<?php
namespace Edith\Admin\Components\Amis;

/**
 * Amis Portlet 门户栏目
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/portlet
 * @method $this tabsClassName(string $tabsClassName)                        Tabs Dom 的类名
 * @method $this contentClassName(string $contentClassName)                  Tabs content Dom 的类名
 * @method $this tabs(array $tabs)                                           tabs 内容
 * @method $this source($source)                                             tabs 关联数据，关联后可以重复生成选项卡
 * @method $this toolbar($toolbar)                                           tabs 中的工具栏，不随 tab 切换而变化
 * @method $this description($description)                                   标题右侧信息
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Portlet extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'portlet';

    /**
     * 隐藏头部
     * @default false
     * @param bool $hideHeader
     * @return Portlet
     */
    public function hideHeader(bool $hideHeader = true): Portlet
    {
        return $this->set('hideHeader', $hideHeader);
    }

    /**
     * 去掉分隔线
     * @default false
     * @param bool $divider
     * @return Portlet
     */
    public function divider(bool $divider = true): Portlet
    {
        return $this->set('divider', $divider);
    }

    /**
     * 只有在点中 tab 的时候才渲染
     * @default false
     * @param bool $mountOnEnter
     * @return Portlet
     */
    public function mountOnEnter(bool $mountOnEnter = true): Portlet
    {
        return $this->set('mountOnEnter', $mountOnEnter);
    }

    /**
     * 切换 tab 的时候销毁
     * @default false
     * @param bool $unmountOnExit
     * @return Portlet
     */
    public function unmountOnExit(bool $unmountOnExit = true): Portlet
    {
        return $this->set('unmountOnExit', $unmountOnExit);
    }

    /**
     * 是否导航支持内容溢出滚动，vertical和chrome模式下不支持该属性；chrome模式默认压缩标签
     * @default false
     * @param bool $scrollable
     * @return Portlet
     */
    public function scrollable(bool $scrollable = true): Portlet
    {
        return $this->set('scrollable', $scrollable);
    }
}