<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Carousel 轮播图
 * @api https://aisuda.bce.baidu.com/amis/zh-CN/components/carousel
 * @method $this options(array $options)                           轮播面板数据
 * @method $this itemSchema(array $itemSchema)                     自定义schema来展示数据
 * @method $this interval(string $interval)                        切换动画间隔 默认 5s
 * @method $this duration(string $duration)                        切换动画时长 默认 0.5s
 * @method $this width(string $width)                              宽度 默认 auto
 * @method $this height(string $height)                            高度 默认 200px
 * @method $this controls(array $controls)                         显示左右箭头、底部圆点索引 默认 ['dots', 'arrows']
 * @method $this controlsTheme(string $controlsTheme)              左右箭头、底部圆点索引颜色，默认light，另有dark模式
 * @method $this animation(string $animation)                      切换动画效果，默认fade，另有slide模式
 * @method $this thumbMode(string $thumbMode)                      图片默认缩放模式  "cover" | "contain"
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Carousel extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'carousel';

    /**
     * 是否自动轮播
     * @default true
     * @param bool $auto
     * @return Carousel
     */
    public function auto(bool $auto = true): Carousel
    {
        return $this->set('auto', $auto);
    }
}