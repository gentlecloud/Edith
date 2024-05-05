<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/***
 * Amis Timeline item
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/timeline#timeline-item
 * @method $this time(string $time)                                  节点时间
 * @method $this title(string $title)                                节点标题
 * @method $this detail(string $detail)                              节点详细描述（折叠）
 * @method $this detailCollapsedText(string $detailCollapsedText)    详细内容折叠时按钮文案 默认 展开
 * @method $this detailExpandedText(string $detailExpandedText)      详细内容展开时按钮文案 默认 折叠
 * @method $this color(string $color)                                时间轴节点颜色 string | level样式（info、success、warning、danger）默认： #DADBDD
 * @method $this icon(string $icon)                                  icon 名，支持 fontawesome v4 或使用 url（优先级高于 color）
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class TimelineItem extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'timeline-item';

    /**
     * construct Timeline Item
     * @param string|null $time 节点时间
     * @param string|null $title 节点标题
     */
    public function __construct(?string $time = null, ?string $title = null)
    {
        parent::__construct();
        !is_null($time) && $this->set('time', $time);
        !is_null($title) && $this->set('title', $title);
    }
}