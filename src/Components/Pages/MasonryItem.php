<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Ant Masonry - 瀑布流
 * docs： https://ant.design/components/masonry-cn
 * @method $this children($children)                                  自定义展示内容，相对 itemRender 具有更高优先级
 * @method $this column(number $column)                               自定义所在列
 * @method $this data($data)                                          自定义存储数据
 * @method $this height(number $height)                               高度
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class MasonryItem extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'masonry-item';
}