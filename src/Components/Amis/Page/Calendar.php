<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Calendar 日历日程
 * @link https://aisuda.bce.baidu.com/amis/zh-CN/components/calendar
 * @method $this schedules(array $schedules)                  日历中展示日程，可设置静态数据或从上下文中取数据，startTime 和 endTime 格式参考文档，className 参考背景色  Array<{startTime: string, endTime: string, content: any, className?: string}> | string
 * @method $this scheduleClassNames($scheduleClassNames)      日历中展示日程的颜色，参考背景色  默认： ['bg-warning', 'bg-danger', 'bg-success', 'bg-info', 'bg-secondary']
 * @method $this scheduleAction($scheduleAction)              自定义日程展示
 * @method $this todayActiveStyle($todayActiveStyle)          今日激活时的自定义样式
 * @author ling
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Calendar extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'calendar';

    /**
     * 放大模式
     * @default false
     * @param bool $largeMode
     * @return Calendar
     */
    public function largeMode(bool $largeMode = true): Calendar
    {
        return $this->set('largeMode', $largeMode);
    }
}