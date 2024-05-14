<?php

namespace Edith\Admin\Support;

use Illuminate\Support\Facades\Cache;

class Captcha
{
    protected ?int $width;

    protected ?int $height;
    protected int $codeNum = 4;
    protected $code;
    protected $im;
    protected $font;

    public function __construct($width = 100, $height = 40, $codeNum = 4)
    {
        $this->width   = $width;
        $this->height  = $height;
        $this->codeNum = $codeNum;
        $this->font    = __DIR__ . '/Database/captcha-2.ttf';
    }

    /**
     * 生成验证码图片
     * @param string|null $uuid
     * @return false|string
     */
    public function showImg(?string $uuid = null)
    {
        //创建图片
        $this->createImg();
        //设置干扰元素
        $this->setDistortion();
        //设置验证码
        $this->createCode($uuid);
        $this->setCaptcha();
        //输出图片
        return $this->outputImg();
    }

    /**
     * 校验验证码
     * @param string $uuid
     * @param string $captcha
     * @return bool
     */
    public function verify(string $uuid, string $captcha): bool
    {
        return strtolower(Cache::get('edith_captcha_' . $uuid)) == strtolower($captcha);
    }

    /**
     * 获取验证码
     * @return mixed
     */
    public function getCaptcha()
    {
        return $this->code;
    }

    /**
     * 创建图片
     * @return void
     */
    protected function createImg()
    {
        $this->im = imagecreatetruecolor($this->width, $this->height);
        $bgColor  = imagecolorallocate($this->im, 255, 255, 255);
        imagefill($this->im, 0, 0, $bgColor);
    }

    /**
     * 设置干扰
     * @param string|null $uuid
     * @return void
     */
    protected function setDistortion(?string $uuid = null)
    {
        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
        for ($i = 0; $i < 10; $i++) {
            //杂点颜色
            $noiseColor = imagecolorallocate($this->im, mt_rand(150, 180), mt_rand(150, 180), mt_rand(150, 180));
            for ($j = 0; $j < 5; $j++) {
                // 添加干扰字符
                imagettftext($this->im,
                    6,
                    mt_rand(-30, 30),
                    mt_rand(-10, $this->width),
                    mt_rand(-10, $this->height),
                    $noiseColor,
                    $this->font,
                    $codeSet[mt_rand(0, 29)]);
            }
        }
    }

    /**
     * 生成验证码
     * @param string|null $uuid
     * @return void
     */
    protected function createCode(?string $uuid)
    {
        $str = "23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ";

        for ($i = 0; $i < $this->codeNum; $i++) {
            $this->code .= $str[rand(0, strlen($str) - 1)];
        }
        if (!empty($uuid)) {
            Cache::put('edith_captcha_' . $uuid, $this->code, 60 * 3);
        }
    }

    /**
     * 写入图片验证码
     * @return void
     */
    protected function setCaptcha()
    {
        for ($i = 0; $i < $this->codeNum; $i++) {
            $color = imagecolorallocate($this->im, rand(0, 150), rand(0, 150), rand(0, 150));
            $x     = floor($this->width / $this->codeNum) * $i + 3;
            $y     = rand(16, $this->height - 5);
            // 更大的字体
            imagettftext($this->im, 16, rand(-30, 30), $x, $y, $color, $this->font, $this->code[$i]);
        }
    }

    /**
     * 输出
     * @return false|string
     */
    protected function outputImg()
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'temp');

        imagepng($this->im, $tempPath);
        if ($fp = fopen($tempPath, "rb", 0)) {
            $gambar = fread($fp, filesize($tempPath));
            fclose($fp);

            $base64 = base64_encode($gambar);
            @unlink($tempPath);
        }

        return $base64;
    }

}