<?php
namespace Gentle\Edith\Components\Amis\Action;

use Gentle\Edith\Components\Amis\AmisRenderer;
use Gentle\Edith\Exceptions\RendererException;

/**
 * Amis PopOver 弹出提示
 * popover 不是一个独立组件，它是嵌入到其它组件中使用的，目前可以在以下组件中配置
 * 参考文档：  https://aisuda.bce.baidu.com/amis/zh-CN/components/popover
 * @method $this size($size)                             当配置成 dialog 或者 drawer 的时候有用。
 * @method $this position($position)                     配置弹出位置，只有 popOver 模式有用，默认是自适应， 可选center, left-top, right-top, left-bottom, right-bottom 等，参考文档
 * @method $this offset(array $offset)                   默认 {top: 0, left: 0}，如果要来一定的偏移请设置这个。
 * @method $this title(string $title)                    弹出框的标题。
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class PopOver extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'pop-over';

    /**
     * 弹窗模式
     * @param string $mode 'popOver', 'dialog', 'drawer'
     * @return PopOver
     * @throws RendererException
     */
    public function mode(string $mode): PopOver
    {
        if (!in_array($mode, ['popOver', 'dialog', 'drawer'])) {
            throw new RendererException("Popover mode only supports popOver, dialog or drawer");
        }
        return $this->set('mode', $mode);
    }

    /**
     * 触发弹出的条件
     * @param string $trigger click | hover
     * @default click
     * @return PopOver
     * @throws RendererException
     */
    public function trigger(string $trigger): PopOver
    {
        if (!in_array($trigger, ['click', 'hover'])) {
            throw new RendererException("Popover trigger only supports click or hover");
        }
        return $this->set('trigger', $trigger);
    }

    /**
     * 是否显示图标。默认会有个放大形状的图标出现在列里面。如果配置成 false，则触发事件出现在列上就会触发弹出。
     * @param bool $showIcon
     * @return PopOver
     */
    public function showIcon(bool $showIcon = true): PopOver
    {
        return $this->set('showIcon', $showIcon);
    }
}