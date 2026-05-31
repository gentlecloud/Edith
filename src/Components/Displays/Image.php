<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;

/**
 * Antd Image
 * @link
 * @method $this alt(string $value)                       图像描述
 * @method $this fallback(string $value)                  加载失败容错地址
 * @method $this height(string|int $value)                图像高度
 * @method $this placeholder(string|bool $value)          加载占位，为 true 时使用默认占位
 * @method $this src(string $value)                       图片地址
 * @method $this width(string|int $value)                 图像宽度
 */
class Image extends EngineRenderer
{
    /**
     * @var string
     */
    public string $renderer = 'image';

    public function __construct(?string $src = null)
    {
        parent::__construct();
        !is_null($src) && $this->set('src', $src);
    }

    /**
     * 预览参数，为 false 时禁用	boolean | PreviewType
     * @param bool|array $value
     * @return self
     */
    public function preview(bool|array $value): self
    {
        return $this->set('preview', $value);
    }
}