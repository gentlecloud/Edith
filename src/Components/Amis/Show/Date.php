<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Date 日期时间
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/date
 * @method $this value(string $value)                          显示的日期数值
 * @method $this name(string $name)                            在其他组件中，时，用作变量映射
 * @method $this placeholder(string $placeholder)              占位内容
 * @method $this format(string $format)                        展示格式, 更多格式类型请参考 文档 默认： YYYY-MM-DD
 * @method $this valueFormat(string $valueFormat)              数据格式，默认为时间戳。更多格式类型请参考 文档 默认： X
 * @method $this updateFrequency(int $updateFrequency)         更新频率， 默认为 1 分钟。 默认： 60000
 * @author Chico
 * @copyright Xiamen Gentle Technology Co., Ltd
 */
class Date extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'date';

    /**
     * 是否显示相对当前的时间描述，比如: 11 小时前、3 天前、1 年前等，fromNow 为 true 时，format 不生效。
     * @default false
     * @param bool $fromNow
     * @return Date
     */
    public function fromNow(bool $fromNow = true): Date
    {
        return $this->set('fromNow', $fromNow);
    }
}