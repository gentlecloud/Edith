<?php
namespace Edith\Admin\Components\Pages;

use Edith\Admin\Components\EngineRenderer;
use Illuminate\Support\Collection;

/**
 * Antd Steps
 * @link https://ant.design/components/steps-cn
 * @method $this current(int $value)                                指定当前步骤，从 0 开始记数。在子 Step 元素中，可以通过 status 属性覆盖状态
 * @method $this direction(string $value)                           指定步骤条方向。目前支持水平（horizontal）和竖直（vertical）两种方向
 * @method $this initial(int $value)                                起始序号，从 0 开始记数
 * @method $this labelPlacement(string $value)                      指定标签放置位置，默认水平放图标右侧，可选 vertical 放图标下方
 * @method $this percent(int $value)                                当前 process 步骤显示的进度条进度（只对基本类型的 Steps 生效）
 * @method $this size(string $value)                                指定大小，目前支持普通（default）和迷你（small）
 * @method $this status(string $value)                              指定当前步骤的状态，可选 wait process finish error
 * @method $this type(string $value)                                步骤条类型，可选 default navigation inline
 */
class Steps extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'steps';

    /**
     * @var Collection|null
     */
    protected ?Collection $items;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * 子标签
     * @param string|null $title 标题
     * @param string|null $status 指定状态。当不配置该属性时，会使用 Steps 的 current 来自动指定状态。可选：wait process finish error
     * @return StepItem
     */
    public function item(?string $title = null, ?string $status = null): StepItem
    {
        return tap(new StepItem($title, $status), function ($value) {
            $this->items->push($value);
        });
    }

    /**
     * @param array $items
     * @return $this
     */
    public function items(array $items): self
    {
        $this->items = new Collection($items);
        return $this;
    }
}