<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Nav导航
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/nav
 * @method $this source($source)                                  可以通过变量或 API 接口动态创建导航 string | API
 * @method $this deferApi($deferApi)                              用来延时加载选项详情的接口，可以不配置，不配置公用 source 接口。
 * @method $this itemActions($itemActions)                        更多操作相关配置
 * @method $this saveOrderApi($saveOrderApi)                      保存排序的 api string | API
 * @method $this itemBadge($itemBadge)                            角标
 * @method $this links(array $links)                              链接集合
 * @method $this overflow(array $overflow)                        响应式收纳配置
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Nav extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'nav';

    /**
     * 设置成 false 可以以 tabs 的形式展示
     * @default true
     * @param bool $stacked
     * @return Nav
     */
    public function stacked(bool $stacked = true): Nav
    {
        return $this->set('stacked', $stacked);
    }

    /**
     * 是否支持拖拽排序
     * @param bool $draggable
     * @return Nav
     */
    public function draggable(bool $draggable = true): Nav
    {
        return $this->set('draggable', $draggable);
    }

    /**
     * 仅允许同层级内拖拽
     * @param bool $dragOnSameLevel
     * @return Nav
     */
    public function dragOnSameLevel(bool $dragOnSameLevel = true): Nav
    {
        return $this->set('dragOnSameLevel', $dragOnSameLevel);
    }
}