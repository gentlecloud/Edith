<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Pagination 分页组件
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/pagination
 * @method $this mode(string $mode)                               迷你版本/简易版本 只显示左右箭头，配合hasNext使用 normal | simple 默认: normal
 * @method $this layout($layout)                                  通过控制layout属性的顺序，调整分页结构布局  string | string[]
 * @method $this maxButtons(int $maxButtons)                      最多显示多少个分页按钮，最小为5 默认5
 * @method $this lastPage(int $lastPage)                          总页数 （设置总条数total的时候，lastPage会重新计算）
 * @method $this total(int $total)                                总条数
 * @method $this activePage(int $activePage)                      当前页数 默认 1
 * @method $this perPage(int $perPage)                            每页显示多条数据 默认 10
 * @method $this perPageAvailable(array $perPageAvailable)        指定每页可以显示多少条  [10, 20, 50, 100]
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Pagination extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'pagination';

    /**
     * 是否展示perPage切换器 layout和showPerPage都可以控制
     * @default false
     * @param bool $showPerPage
     * @return Pagination
     */
    public function showPerPage(bool $showPerPage = true): Pagination
    {
        return $this->set('showPerPage', $showPerPage);
    }

    /**
     * 是否显示快速跳转输入框 layout和showPageInput都可以控制
     * @default false
     * @param bool $showPageInput
     * @return Pagination
     */
    public function showPageInput(bool $showPageInput = true): Pagination
    {
        return $this->set('showPageInput', $showPageInput);
    }
}