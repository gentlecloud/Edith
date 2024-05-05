<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Avatar 头像
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/avatar
 * @method $this fit(string $fit)                             具体细节可以参考 MDN 文档  'contain' | 'cover' | 'fill' | 'none' | 'scale-down'
 * @method $this src(string $src)                             图片地址
 * @method $this text(string $text)                           文字
 * @method $this icon(string $icon)                           图标  'fa fa-user'
 * @method $this size(string $size)                           'default' | 'normal' | 'small'三种字符串类型代表不同大小（分别是48、40、32），也可以直接数字表示 默认： default
 * @method $this gap(int $gap)                                控制字符类型距离左右两侧边界单位像素 默认 ： 4
 * @method $this alt(string $alt)                             图像无法显示时的替代文本
 * @method $this onError(string $onError)                     图片加载失败的字符串，这个字符串是一个New Function内部执行的字符串，参数是event（使用event.nativeEvent获取原生dom事件），这个字符串需要返回boolean值。设置 "return ture;" 会在图片加载失败后，使用 text 或者 icon 代表的信息来进行替换。目前图片加载失败默认是不进行置换。注意：图片加载失败，不包括$获取数据为空情况
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Avatar extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'avatar';

    /**
     * 形状，有三种 'circle' （圆形）、'square'（正方形）、'rounded'（圆角）
     * @param string $shape circle | square | rounded
     * @return Avatar
     * @throws \Exception
     */
    public function shape(string $shape): Avatar
    {
        if (!in_array($shape, ['circle', 'square', 'rounded'])) {
            throw new \Exception("Shape only supports 'circle', 'square', 'rounded'");
        }
        return $this->set('shape', $shape);
    }

    /**
     * 图片的 CORS 属性设置
     * @param string $crossOrigin 'anonymous' | 'use-credentials'
     * @return Avatar
     * @throws \Exception
     */
    public function crossOrigin(string $crossOrigin): Avatar
    {
        if (!in_array($crossOrigin, ['anonymous', 'use-credentials', ''])) {
            throw new \Exception("Cross origin only supports 'anonymous', 'use-credentials', ''");
        }
        return $this->set('crossOrigin', $crossOrigin);
    }

    /**
     * 图片是否允许拖动
     * @param bool $draggable
     * @return Avatar
     */
    public function draggable(bool $draggable = true): Avatar
    {
        return $this->set('draggable', $draggable);
    }
}