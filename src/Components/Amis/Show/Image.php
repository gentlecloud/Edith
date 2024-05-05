<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Amis Image
 * 文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/image
 * @method $this innerClassName(string $innerClassName)                        组件内层 CSS 类名
 * @method $this imageClassName(string $imageClassName)                        图片 CSS 类名
 * @method $this thumbClassName(string $thumbClassName)                        图片缩率图 CSS 类名
 * @method $this height($height)                                               图片缩率高度
 * @method $this width($width)                                                 图片缩率宽度
 * @method $this title(string $title)                                          标题
 * @method $this imageCaption(string $imageCaption)                            描述
 * @method $this placeholder(string $placeholder)                              占位文本
 * @method $this defaultImage(string $defaultImage)                            无数据时显示的图片
 * @method $this src(string $src)                                              缩略图地址
 * @method $this href(string $href)                                            外部链接地址
 * @method $this originalSrc(string $originalSrc)                              原图地址
 * @method $this enlargeTitle(string $enlargeTitle)                            放大预览的标题
 * @method $this enlargeCaption(string $enlargeCaption)                        放大预览的描述
 * @method $this toolbarActions($toolbarActions)                               图片工具栏，支持旋转，缩放，默认操作全部开启
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Image extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * 如果在 Table、Card 和 List 中，为"image"；在 Form 中用作静态展示，为"static-image"
     * @var string
     */
    protected string $type = 'image';

    /**
     * construct image
     * @param string|null $src
     */
    public function __construct(?string $src = null)
    {
        parent::__construct();
        !is_null($src) && $this->set('src', $src);
    }

    /**
     * 支持放大预览
     * @param bool $enlargeAble
     * @return Image
     */
    public function enlargeAble(bool $enlargeAble = true): Image
    {
        return $this->set('enlargeAble', $enlargeAble);
    }

    /**
     * 预览图模式
     * @param string $thumbMode 'w-full' | 'h-full' | 'contain' | 'cover'
     * @return Image
     * @throws \Exception
     * @default contain
     */
    public function thumbMode(string $thumbMode): Image
    {
        if (!in_array($thumbMode, ['w-full', 'h-full', 'contain', 'cover'])) {
            throw new \Exception("thumbMode only supports 'w-full' 、 'h-full' 、 'contain'、 'cover'");
        }
        return $this->set('thumbMode', $thumbMode);
    }

    /**
     * 预览图比例
     * @param string $thumbRatio '1:1' | '4:3' | '16:9'
     * @return Image
     * @throws \Exception
     */
    public function thumbRatio(string $thumbRatio): Image
    {
        if (!in_array($thumbRatio, ['1:1', '4:3', '16:9'])) {
            throw new \Exception("ThumbRatio only supports '1:1','4:3','16:9'");
        }
        return $this->set('thumbRatio', $thumbRatio);
    }

    /**
     * 图片展示模式 缩略图模式 或者 原图模式
     * @param string $imageMode thumb | original
     * @return Image
     * @throws \Exception
     */
    public function imageMode(string $imageMode): Image
    {
        if (!in_array($imageMode, ['thumb', 'original'])) {
            throw new \Exception("ImageMode only supports 'thumb','original'");
        }
        return $this->set('imageMode', $imageMode);
    }

    /**
     * 放大模式下是否展示图片的工具栏
     * @default false
     * @param bool $showToolbar
     * @return Image
     */
    public function showToolbar(bool $showToolbar = true): Image
    {
        return $this->set('showToolbar', $showToolbar);
    }
}