<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\Amis\AmisRenderer;
use Illuminate\Support\Collection;

/**
 * Amis Toast 轻提示
 * 参考文档:   https://aisuda.bce.baidu.com/amis/zh-CN/components/toast
 * @method $this timeout(int $timeout)                            持续时间 默认：  5000（error类型为6000，移动端为3000）
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Toast extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'toast';

    /**
     * 轻提示内容
     * @var Collection
     */
    protected Collection $items;

    /**
     * construct Toast
     */
    public function __construct()
    {
        parent::__construct();
        $this->items = new Collection();
    }

    /**
     * 提示显示位置
     * @default top-center（移动端为center）
     * @param string $position 'top-right' | 'top-center' | 'top-left' | 'bottom-center' | 'bottom-left' | 'bottom-right' | 'center'
     * @return $this
     * @throws \Exception
     */
    public function position(string $position): Toast
    {
        if (!in_array($position, ['top-right','top-center','top-left','bottom-center','bottom-left','bottom-right','center'])) {
            throw new \Exception("Badge position only supports 'top-right','top-center','top-left','bottom-center','bottom-left','bottom-right','center'");
        }
        return $this->set('position', $position);
    }

    /**
     * 是否展示关闭按钮
     * @default false
     * @param bool $closeButton
     * @return Toast
     */
    public function closeButton(bool $closeButton = true): Toast
    {
        return $this->set('closeButton', $closeButton);
    }

    /**
     * 是否展示图标
     * @default true
     * @param bool $showIcon
     * @return Toast
     */
    public function showIcon(bool $showIcon = true): Toast
    {
        return $this->set('showIcon', $showIcon);
    }

    /**
     * 轻提示内容
     * @param array|Collection $items
     * @return Toast
     */
    public function items($items): Toast
    {
        if (is_array($items)) {
            $items = new Collection($items);
        }
        return $this->set('items', $items);
    }

    /**
     * 添加轻提示
     * @param string|null $title
     * @return ToastItem
     */
    public function item(?string $title = null): ToastItem
    {
        return tap(new ToastItem($title), function ($value) {
            $this->items->push($value);
        });
    }
}