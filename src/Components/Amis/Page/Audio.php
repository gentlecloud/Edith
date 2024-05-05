<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Audio 音频
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/audio
 * @method $this src(string $src)                          音频地址
 * @method $this rates(array $rates)                       可配置音频播放倍速如：[1.0, 1.5, 2.0]
 * @method $this controls(array $controls)                 内部模块定制化 默认：  ['rates', 'play', 'time', 'process', 'volume']
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Audio extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'audio';

    /**
     * 是否是内联模式
     * @default true
     * @param bool $inline
     * @return Audio
     */
    public function inline(bool $inline = true): Audio
    {
        return $this->set('inline', $inline);
    }

    /**
     * 是否循环播放
     * @default false
     * @param bool $loop
     * @return Audio
     */
    public function loop(bool $loop = true): Audio
    {
        return $this->set('loop', $loop);
    }

    /**
     * 是否自动播放
     * @default false
     * @param bool $autoPlay
     * @return Audio
     */
    public function autoPlay(bool $autoPlay = true): Audio
    {
        return $this->set('autoPlay', $autoPlay);
    }
}