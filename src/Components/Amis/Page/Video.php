<?php
namespace Gentle\Edith\Components\Amis\Page;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Video 视频
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/video
 * @method $this src(string $src)                                   视频地址
 * @method $this videoType(string $videoType)                       指定直播视频格式
 * @method $this poster(string $poster)                             视频封面地址
 * @method $this rates(array $rates)                                倍数，格式为[1.0, 1.5, 2.0]
 * @method $this frames(object $frames)                             key 是时刻信息，value 可以可以为空，可有设置为图片地址，请看参考文档示例
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Video extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'video';

    /**
     * 是否为直播，视频为直播时需要添加上，支持flv和hls格式
     * @default false
     * @param bool $isLive
     * @return Video
     */
    public function isLive(bool $isLive = true): Video
    {
        return $this->set('isLive', $isLive);
    }

    /**
     * 是否静音
     * @param bool $muted
     * @return Video
     */
    public function muted(bool $muted = true): Video
    {
        return $this->set('muted', $muted);
    }

    /**
     * 是否自动播放
     * @param bool $autoPlay
     * @return Video
     */
    public function autoPlay(bool $autoPlay = true): Video
    {
        return $this->set('autoPlay', $autoPlay);
    }

    /**
     * 点击帧的时候默认是跳转到对应的时刻，如果想提前 3 秒钟，可以设置这个值为 3
     * @param bool $jumpBufferDuration
     * @return Video
     */
    public function jumpBufferDuration(bool $jumpBufferDuration = true): Video
    {
        return $this->set('jumpBufferDuration', $jumpBufferDuration);
    }

    /**
     * 到了下一帧默认是接着播放，配置这个会自动停止
     * @param bool $stopOnNextFrame
     * @return Video
     */
    public function stopOnNextFrame(bool $stopOnNextFrame = true): Video
    {
        return $this->set('stopOnNextFrame', $stopOnNextFrame);
    }
}