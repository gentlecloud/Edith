<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Antd Anchor
 * @link https://ant.design/components/anchor-cn
 * @method $this bounds(int $value)                             锚点区域边界
 * @method $this offsetTop(int $value)                          距离窗口顶部达到指定偏移量后触发
 * @method $this targetOffset(int $value)                       锚点滚动偏移量，默认与 offsetTop 相同，例子
 * @method $this direction(string $value)                       设置导航方向	vertical | horizontal
 */
class Anchor extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'anchor';

    /**
     * @param array|Collection $items
     * @return self
     */
    public function items(array|Collection $items): self
    {
        return $this->set('items', is_array($items) ? new Collection($items) : $items);
    }

    /**
     * 固定模式	boolean | Omit<AffixProps, 'offsetTop' | 'target' | 'children'>
     * @param bool|array $value
     * @return self
     */
    public function affix(bool|array $value = true): self
    {
        return $this->set('affix', $value);
    }

    /**
     * affix={false} 时是否显示小方块
     * @param bool $value
     * @return self
     */
    public function showInkInFixed(bool $value = true): self
    {
        return $this->set('showInkInFixed', $value);
    }

    /**
     * 替换浏览器历史记录中项目的 href 而不是推送它
     * @param bool $value
     * @return self
     */
    public function replace(bool $value = true): self
    {
        return $this->set('replace', $value);
    }
}