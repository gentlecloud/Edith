<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Badge 角标
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/badge
 * @method $this text(string $text)                              角标文案，支持字符串和数字，在 mode='dot'下设置无效
 * @method $this size(int $size)                                 角标大小
 * @method $this overflowCount(int $overflowCount)               设置封顶的数字值 默认： 99
 * @method $this offset(array $offset)                           角标位置，offset 相对于 position 位置进行水平、垂直偏移  number[top, left]
 * @method $this visibleOn(string $visibleOn)                    控制角标的显示隐藏
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Badge extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'badge';

    /**
     * 角标类型
     * @param string $mode dot | text | ribbon
     * @default dot
     * @return Badge
     * @throws \Exception
     */
    public function mode(string $mode): Badge
    {
        if (!in_array($mode, ['dot', 'text', 'ribbon'])) {
            throw new \Exception("Badge mode only supports 'dot', 'text', 'ribbon'");
        }
        return $this->set('mode', $mode);
    }

    /**
     * 角标级别, 设置之后角标背景颜色不同
     * @param string $level info | success | warning | danger
     * @return Badge
     * @throws \Exception
     */
    public function level(string $level): Badge
    {
        if (!in_array($level, ['info', 'success', 'warning', 'danger'])) {
            throw new \Exception("Badge level only supports 'info', 'success', 'warning', 'danger'");
        }
        return $this->set('level', $level);
    }

    /**
     * 角标位置
     * @param string $position  top-right | top-left | bottom-right | bottom-left
     * @default top-right
     * @return Badge
     * @throws \Exception
     */
    public function position(string $position): Badge
    {
        if (!in_array($position, ['top-right', 'top-left', 'bottom-right', 'bottom-left'])) {
            throw new \Exception("Badge position only supports 'top-right', 'top-left', 'bottom-right', 'bottom-left'");
        }
        return $this->set('position', $position);
    }

    /**
     * 角标是否显示动画
     * @param bool $animation
     * @return Badge
     */
    public function animation(bool $animation): Badge
    {
        return $this->set('animation', $animation);
    }
}