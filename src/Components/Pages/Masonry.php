<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Ant Masonry - 瀑布流
 * docs： https://ant.design/components/masonry-cn
 * @method $this classNames(string $classNames)                       用于自定义组件内部各语义化结构的 class，支持对象或函数
 * @method $this columns(number|array $columns)                       列数，可以是固定值或响应式配置
 * @method $this gutter(number|array $gutter)                         间距，可以是固定值、响应式配置或水平垂直间距配置
 * @method $this itemRender($render)                                  自定义项渲染
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Masonry extends EngineRenderer
{
    /**
     * Edith 渲染组件
     * @var string
     */
    public string $renderer = 'masonry';

    /**
     * @var Collection
     */
    protected Collection $items;

    /**
     * construct Masonry
     */
    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * 是否持续监听子项尺寸变化
     * @param bool $refresh
     * @default false
     * @return self
     */
    public function fresh(bool $refresh = false): self
    {
        return $this->set('fresh', $refresh);
    }

    /**
     * 瀑布流项
     * @param Collection|array $items
     * @return $this
     */
    public function items(Collection|array $items): self
    {
        if (is_array($items)) {
            $items = new Collection($items);
        }
        $this->items = $items;
        return $this;
    }
}