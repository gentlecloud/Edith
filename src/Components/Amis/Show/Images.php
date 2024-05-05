<?php
namespace Gentle\Edith\Components\Amis\Show;

use Gentle\Edith\Components\Amis\AmisRenderer;

/**
 * Images 图片集
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/images
 * @method $this defaultImage(string $defaultImage)                       默认展示图片
 * @method $this value($value)                                            图片数组 string或Array<string>或Array<object>
 * @method $this source(string $source)                                   数据源
 * @method $this delimiter(string $delimiter)                             分隔符，当 value 为字符串时，用该值进行分隔拆分 默认： ","
 * @method $this src(string $src)                                         预览图地址，支持数据映射获取对象中图片变量
 * @method $this originalSrc(string $originalSrc)                         原图地址，支持数据映射获取对象中图片变量
 * @method $this toolbarActions(array $toolbarActions)                    图片工具栏，支持旋转，缩放，默认操作全部开启
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Images extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * 如果在 Table、Card 和 List 中，为"images"；在 Form 中用作静态展示，为"static-images"
     * @var string
     */
    protected string $type = 'images';

    /**
     * 预览图模式
     * @param string $thumbMode 'w-full' | 'h-full' | 'contain' | 'cover'
     * @return $this
     * @throws \Exception
     * @default contain
     */
    public function thumbMode(string $thumbMode): Images
    {
        if (!in_array($thumbMode, ['w-full', 'h-full', 'contain', 'cover'])) {
            throw new \Exception("thumbMode only supports 'w-full' 、 'h-full' 、 'contain'、 'cover'");
        }
        return $this->set('thumbMode', $thumbMode);
    }

    /**
     * 预览图比例
     * @param string $thumbRatio '1:1' | '4:3' | '16:9'
     * @return $this
     * @throws \Exception
     */
    public function thumbRatio(string $thumbRatio): Images
    {
        if (!in_array($thumbRatio, ['1:1', '4:3', '16:9'])) {
            throw new \Exception("ThumbRatio only supports '1:1','4:3','16:9'");
        }
        return $this->set('thumbRatio', $thumbRatio);
    }

    /**
     * 支持放大预览
     * @param bool $enlargeAble
     * @return Images
     */
    public function enlargeAble(bool $enlargeAble = true): Images
    {
        return $this->set('enlargeAble', $enlargeAble);
    }

    /**
     * 放大模式下是否展示图片的工具栏
     * @default false
     * @param bool $showToolbar
     * @return Images
     */
    public function showToolbar(bool $showToolbar = true): Images
    {
        return $this->set('showToolbar', $showToolbar);
    }
}