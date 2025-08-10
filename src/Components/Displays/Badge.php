<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Badge
 * @link https://ant.design/components/badge-cn
 * @method $this color(string $value)                               自定义小圆点的颜色
 * @method $this count(string|int $value)                           展示的数字，大于 overflowCount 时显示为 ${overflowCount}+，为 0 时隐藏
 * @method $this classNames(array $value)                           语义化结构 class Record<SemanticDOM, string>
 * @method $this offset(array $value)                               设置状态点的位置偏移
 * @method $this overflowCount(int $value)                          展示封顶的数字值
 * @method $this size(string $value)                                在设置了 count 的前提下有效，设置小圆点的大小	default | small
 * @method $this status(string $value)                              设置 Badge 为状态点	success | processing | default | error | warning
 * @method $this text(string $value)                                在设置了 status 的前提下有效，设置状态点的文本
 * @method $this title(string $value)                               设置鼠标放在状态点上时显示的文字
 */
class Badge extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'badge';

    /**
     * 不展示数字，只有一个小红点
     * @param bool $dot
     * @return self
     */
    public function dot(bool $dot = true): self
    {
        return $this->set('dot', $dot);
    }

    /**
     * 当数值为 0 时，是否展示 Badge
     * @param bool $showZero
     * @return self
     */
    public function showZero(bool $showZero = true): self
    {
        return $this->set('showZero', $showZero);
    }
}