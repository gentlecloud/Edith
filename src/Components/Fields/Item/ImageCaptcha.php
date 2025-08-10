<?php
namespace Edith\Admin\Components\Fields\Item;

use Edith\Admin\Components\Fields\Field;

/**
 * Edith 图片验证码
 * @method $this source(string $url)                      图形验证码API
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class ImageCaptcha extends Field
{
    /**
     * @var string
     */
    public string $component = 'image-captcha';
}