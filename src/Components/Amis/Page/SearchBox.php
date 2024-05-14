<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Search Box 搜索框
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/search-box
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class SearchBox extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'search-box';

    /**
     * 是否为 mini 模式
     * @param bool $mini
     * @return SearchBox
     */
    public function mini(bool $mini = true): SearchBox
    {
        return $this->set('mini', $mini);
    }

    /**
     * 是否立即搜索
     * @param bool $searchImediately
     * @return SearchBox
     */
    public function searchImediately(bool $searchImediately = true): SearchBox
    {
        return $this->set('searchImediately', $searchImediately);
    }

    /**
     * 清空搜索框内容后立即执行搜索
     * @param bool $clearAndSubmit
     * @return SearchBox
     */
    public function clearAndSubmit(bool $clearAndSubmit = true): SearchBox
    {
        return $this->set('clearAndSubmit', $clearAndSubmit);
    }
}