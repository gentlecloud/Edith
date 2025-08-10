<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\BaseRenderer;

/**
 * Antd Timeline
 * @link https://ant.design/components/timeline-cn
 * @method $this color(string $value)                               指定圆圈颜色 blue、red、green、gray，或自定义的色值
 * @method $this dot(string $value)                                 自定义时间轴点
 * @method $this label(string $value)                               设置标签
 * @method $this children(string $value)                            设置内容
 * @method $this position(string $value)                            自定义节点位置	left | right
 */
class TimelineItem extends BaseRenderer
{
    /**
     * @param string|null $label
     */
    public function __construct(?string $label = null)
    {
        !is_null($label) && $this->set('label', $label);
    }
}