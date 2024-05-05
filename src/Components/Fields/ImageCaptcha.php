<?php
namespace Gentle\Edith\Components\Fields;

/**
 * Edith 图片验证码
 * @method $this captcha(string $url)                      图形验证码API
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class ImageCaptcha extends Field
{
    /**
     * @var string
     */
    public string $component = 'image-captcha';
}