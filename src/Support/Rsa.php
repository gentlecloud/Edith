<?php
namespace Edith\Admin\Support;

class Rsa
{
    /**
     * 支付宝公钥
     * @var string
     */
    private string $public_key = "";

    /**
     * 支付宝私钥
     * @var string
     */
    private string $private_key = "";

    /**
     * 加载 Rsa 证书
     * @param string|null $publicKey
     * @param string|null $privateKey
     */
    public function __construct(?string $publicKey = null,?string $privateKey = null)
    {
        if (empty($publicKey)) {
            $publicKey = env("RSA_PUBLIC_KEY");
        }

        if (empty($privateKey)) {
            $privateKey = env("RSA_PRIVATE_KEY");
        }

        $this->setCert($publicKey, $privateKey);
    }

    /**
     * 设置公钥和私钥
     * @param string|null $publicKey 公钥
     * @param string|null $privateKey 私钥
     * @return $this
     */
    public function setCert(?string $publicKey = null, ?string $privateKey = null): Rsa
    {
        if (!is_null($publicKey)) {
            !str_contains($publicKey, 'BEGIN PUBLIC KEY') && $publicKey = "-----BEGIN PUBLIC KEY-----\n" . $publicKey . "\n-----END PUBLIC KEY-----";
            $this->public_key = $publicKey;
        }

        if (!is_null($privateKey)) {
            !str_contains($privateKey, 'BEGIN PRIVATE KEY') && $privateKey = "-----BEGIN PRIVATE KEY-----\n" . $privateKey . "\n-----END PRIVATE KEY-----";
            $this->private_key = $privateKey;
        }
        return $this;
    }


    /**
     * 支付宝RSA加密
     * @param array|string $content
     * @return string|null
     */
    public function encrypt($content): ?string
    {
        if (is_array($content)) {
            $content = json_encode($content);
        }
        $public_key = openssl_pkey_get_public($this->public_key);
        if (!$public_key || !is_string($content)) {
            return null; // 公钥或加密字符串不可用
        }
        openssl_public_encrypt($content,$encrypted,$public_key);
        return base64_encode($encrypted);
    }

    /**
     * 支付宝RSA解密
     * @param string $content
     * @return string|null
     */
    public function decrypt(string $content): ?string
    {
        $private_key = openssl_pkey_get_private($this->private_key);
        if (!$private_key) {
            return null;
        }
        openssl_private_decrypt(base64_decode($content),$decrypted,$private_key);
        return $decrypted;
    }

    /**
     * 构造签名
     * @param string $dataString 被签名数据
     * @return string
     */
    public function sign(string $dataString): string
    {
        $signature = null;
        openssl_sign($dataString, $signature, $this->private_key);
        return base64_encode($signature);
    }

    /**
     * 验证签名
     * @param string $dataString 被签名数据
     * @param string $signString 已经签名的字符串
     * @return bool
     */
    public function verify(string $dataString, string $signString): bool
    {
        $signature = base64_decode($signString);
        return (bool) openssl_verify($dataString, $signature, $this->public_key);
    }

    /**
     * 生成公钥和私钥
     * @param int $bits
     * @return array
     * @throws \Exception
     */
    public function generate(int $bits = 2048): array
    {
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => $bits, //字节数  512 1024 2048  4096 等
            "private_key_type" => OPENSSL_KEYTYPE_RSA // 加密类型
        );
        $res = openssl_pkey_new($config);
        if (!$res) {
            throw new \Exception('生成失败.');
        }
        openssl_pkey_export($res, $private_key);
        $public_key = openssl_pkey_get_details($res);
        return [
            'public_key' => $public_key["key"],
            'private_key' => $private_key
        ];
    }
}
