<?php
namespace Gentle\Edith\Components\Layouts;

use Gentle\Edith\Components\Renderer;

/**
 * Ant Space 间距
 * 设置组件之间的间距。
 * 参考文档： https://ant.design/components/space-cn
 * @method $this align(string $align)                                对齐方式 start | end |center | baseline
 * @method $this direction(string $direction)                        间距方向 vertical | horizontal  默认： horizontal
 * @method $this size($size)                                         间距大小  Size | Size[]  ， 默认： small
 * @method $this split($split)                                       设置拆分
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 * @link https://www.3ii.cn
 */
class Space extends Renderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'edith';

    /**
     * Edith 渲染部件
     * @var string 
     */
    protected string $renderer = 'space';

    /**
     * 是否自动换行，仅在 horizontal 时有效
     * @param bool $wrap
     * @default false
     * @return Space
     */
    public function wrap(bool $wrap): Space
    {
        return $this->set('wrap', $wrap);
    }
}