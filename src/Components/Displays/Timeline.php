<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Antd Timeline
 * @link https://ant.design/components/timeline-cn
 * @method $this mode(string $value)                                通过设置 mode 可以改变时间轴和内容的相对位置	left | alternate | right
 * @method $this pending(string|bool $value)                        指定最后一个幽灵节点是否存在或内容
 * @method $this pendingDot(string $value)                          当最后一个幽灵节点存在時，指定其时间图点
 */
class Timeline extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'timeline';

    /**
     * @var Collection|null
     */
    protected ?Collection $items;

    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * 节点排序
     * @param bool $value
     * @return self
     */
    public function reverse(bool $value = true): self
    {
        return $this->set('reverse', $value);
    }

    /**
     * @param string $label
     * @return TimelineItem
     */
    public function item(string $label): TimelineItem
    {
        return tap(new TimelineItem($label), function ($value) {
            $this->items->push($value);
        });
    }

    /**
     * @param array $items
     * @return self
     */
    public function items(array $items): self
    {
        return $this->set('items', new Collection($items));
    }
}