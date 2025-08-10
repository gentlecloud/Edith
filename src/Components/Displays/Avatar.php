<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Avatar
 * @link https://ant-design.antgroup.com/components/avatar-cn
 * @method $this alt(string $value)                             图像无法显示时的替代文本
 * @method $this gap(int $value)                                字符类型距离左右两侧边界单位像素
 * @method $this icon(string $value)                            设置头像的自定义图标
 * @method $this shape(string $value)                           指定头像的形状	circle | square
 * @method $this size(int|string $value)                        设置头像的大小	number | large | small | default | { xs: number, sm: number, ...}
 * @method $this src(string $value)                             图片类头像的资源地址或者图片元素
 * @method $this srcSet(string $value)                          设置图片类头像响应式资源地址
 * @method $this crossOrigin(string $value)                     CORS 属性设置	'anonymous' | 'use-credentials' | ''
 */
class Avatar extends EngineRenderer
{
    /**
     * @var string
     */
    protected string $renderer = 'avatar';

    /**
     * @param string|null $src
     */
    public function __construct(?string $src = null)
    {
        parent::__construct();
        !is_null($src) && $this->set('src', $src);
    }

    /**
     * 图片是否允许拖动	boolean | 'true' | 'false'
     * @param bool|string $value
     * @return self
     */
    public function draggable(bool|string $value = true): self
    {
        return $this->set('draggable', $value);
    }
}