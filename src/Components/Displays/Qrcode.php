<?php
namespace Edith\Admin\Components\Displays;

use Edith\Admin\Components\EngineRenderer;
use Edith\Admin\Exceptions\RendererException;

/**
 * Antd QRCode
 * @link https://ant-design.antgroup.com/components/qr-code-cn
 * @method $this value(string $value)                               扫描后的文本
 * @method $this type(string $value)                                渲染类型	canvas | svg
 * @method $this icon(string $value)                                二维码中图片的地址（目前只支持图片地址）
 * @method $this size(int $value)                                   二维码大小
 * @method $this iconSize(int|array $value)                         二维码中图片的大小	number | { width: number; height: number }
 * @method $this color(string $value)                               二维码颜色 #000
 * @method $this bgColor(string $value)                             二维码背景颜色 transparent
 * @method $this statusRender(array|object|string $value)           自定义状态渲染器
 */
class Qrcode extends EngineRenderer
{
    /**
     * @var string 
     */
    public string $renderer = 'qrcode';

    /**
     * 二维码纠错等级
     * @param string $value
     * @return self
     * @throws RendererException
     */
    public function errorLevel(string $value): self
    {
        if (!in_array($value, ['L', 'M', 'Q', 'H'])) {
            throw new RendererException("QRCode ErrorLevel Invalid value: $value");
        }
        return $this->set('errorLevel', $value);
    }

    /**
     * 二维码状态
     * @param string $value
     * @return self
     * @throws RendererException
     */
    public function status(string $value): self
    {
        if (!in_array($value, ['active', 'expired', 'loading', 'scanned'])) {
            throw new RendererException("QRCode status Invalid value: $value");
        }
        return $this->set('status', $value);
    }

    /**
     * 是否有边框
     * @param bool $value
     * @return self
     */
    public function bordered(bool $value = true): self
    {
        return $this->set('bordered', $value);
    }
}