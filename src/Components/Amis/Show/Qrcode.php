<?php
namespace Edith\Admin\Components\Amis\Show;

use Edith\Admin\Components\Amis\AmisRenderer;

/**
 * Amis Qrcode 二维码
 * 参考文档： https://aisuda.bce.baidu.com/amis/zh-CN/components/qrcode
 * @method $this qrcodeClassName(string $qrcodeClassName)                           二维码 SVG 的类名
 * @method $this codeSize(int $codeSize)                                            二维码的宽高大小
 * @method $this backgroundColor(string $backgroundColor)                           二维码背景色 默认： #fff
 * @method $this foregroundColor(string $foregroundColor)                           二维码前景色 默认： "#000"
 * @method $this value(string $value)                                               扫描二维码后显示的文本，如果要显示某个页面请输入完整 url（"http://..."或"https://..."开头），支持使用 模板
 * @method $this imageSettings(array $imageSettings)                                QRCode 图片配置
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Qrcode extends AmisRenderer
{
    /**
     * Amis 渲染类型
     * @var string
     */
    protected string $type = 'qrcode';

    /**
     * 二维码复杂级别
     * @param string $level 'L' 'M' 'Q' 'H'
     * @return Qrcode
     * @throws \Exception
     */
    public function level(string $level): Qrcode
    {
        if (!in_array($level, ['L', 'M', 'Q', 'H'])) {
            throw new \Exception("Qrcode Level only supports 'L', 'M', 'Q', 'H'");
        }
        return $this->set('level', $level);
    }
}