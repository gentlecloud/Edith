<?php
namespace Edith\Admin\Components\Amis\Page;

use Edith\Admin\Components\Amis\AmisRenderer;
use Edith\Admin\Exceptions\RendererException;
use Illuminate\Support\Collection;

/**
 * Amis Timeline 时间轴
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/timeline
 * @method $this source($source)                 数据源，可通过数据映射获取当前数据域变量、或者配置 API 对象
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Timeline extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'timeline';

    /**
     * 节点数据
     * @var Collection
     */
    protected Collection $items;

    /**
     * construct Timeline
     */
    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * 指定文字相对于时间轴的位置，仅 direction=vertical 时支持
     * @default right
     * @param string $mode left | right | alternate
     * @return Timeline
     * @throws RendererException
     */
    public function mode(string $mode): Timeline
    {
        if (!in_array($mode, ['left', 'right', 'alternate'])) {
            throw new RendererException("Timeline mode only supports left, right or alternate");
        }
        return $this->set('mode', $mode);
    }

    /**
     * 时间轴方向
     * @default vertical
     * @param string $direction vertical | horizontal
     * @return Timeline
     * @throws RendererException
     */
    public function direction(string $direction): Timeline
    {
        if (!in_array($direction, ['vertical', 'horizontal'])) {
            throw new RendererException("Timeline direction only supports vertical or horizontal");
        }
        return $this->set('direction', $direction);
    }

    /**
     * 根据时间倒序显示
     * @default false
     * @param bool $reverse
     * @return Timeline
     */
    public function reverse(bool $reverse = true): Timeline
    {
        return $this->set('reverse', $reverse);
    }

    /**
     * 配置节点数据
     * @param $items
     * @return Timeline
     */
    public function items($items): Timeline
    {
        if (is_array($items)) {
            $items = new Collection($items);
        }
        return $this->set('items', $items);
    }

    /**
     * 添加节点
     * @param string|null $time 节点时间
     * @param string|null $title 节点标题
     * @return TimelineItem
     */
    public function item(?string $time = null, ?string $title = null): TimelineItem
    {
        return tap(new TimelineItem($time, $title), function ($value) {
            $this->items->push($value);
        });
    }
}