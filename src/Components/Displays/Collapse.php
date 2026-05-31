<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Antd Collapse
 * @link https://ant.design/components/collapse-cn#collapse
 * @method $this activeKey(string|array $value)                             当前激活 tab 面板的 key    string[] | string | number[] | number
 * @method $this defaultActiveKey(string|array $value)                      初始化选中面板的 key   string[] | string | number[] | number
 * @method $this collapsible(string $value)                                 所有子面板是否可折叠或指定可折叠触发区域	header | icon | disabled
 * @method $this expandIcon(string|array|object $value)                     自定义切换图标
 * @method $this expandIconPosition(string $value)                          设置图标位置	start | end
 * @method $this size(string $value)                                        设置折叠面板大小	large | middle | small
 */
class Collapse extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'collapse';

    /**
     * @var Collection|null
     */
    protected ?Collection $items;

    /**
     * construct Collapse
     */
    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * @param array $items
     * @return self
     */
    public function items(array $items): self
    {
        return $this->set('items', new Collection($items));
    }

    /**
     * @param string $key
     * @param string $label
     * @return CollapseItem
     */
    public function item(string $key, string $label): CollapseItem
    {
        return tap(new CollapseItem($key, $label), function ($value) {
            $this->items->push($value);
        });
    }

    /**
     * 带边框风格的折叠面板
     * @param bool $value
     * @return self
     */
    public function bordered(bool $value = true): self
    {
        return $this->set('bordered', $value);
    }

    /**
     * 销毁折叠隐藏的面板
     * @param bool $value
     * @return self
     */
    public function destroyOnHidden(bool $value =  true): self
    {
        return $this->set('destroyOnHidden', $value);
    }

    /**
     * 使折叠面板透明且无边框
     * @param bool $value
     * @return self
     */
    public function ghost(bool $value =  true): self
    {
        return $this->set('ghost', $value);
    }
}