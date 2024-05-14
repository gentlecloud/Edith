<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis PDFViewer PDF 阅读器
 * 参考文档：https://aisuda.bce.baidu.com/amis/zh-CN/components/pdf-viewer
 * @method $this src(string $src)                                 PDF 文件地址
 * @method $this height(string $height)                           高度
 * @method $this width(string $width)                             宽度
 * @method $this showAll(bool $showAll)                           是否显示全部页面 默认： false
 * @method $this background(string $color)                        背景色 默认： #fff
 */
class PDFViewer extends AmisRenderer
{
    /**
     *
     * @var string
     */
    protected string $type = 'pdf-viewer';
}