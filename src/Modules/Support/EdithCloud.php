<?php
declare(strict_types=1);
namespace Edith\Admin\Modules\Support;

use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Support\Rsa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

final class EdithCloud
{
    /**
     * 流式验证
     * @param Request $request
     * @return bool
     */
    public static function isZipStream(Request $request): bool
    {
        $header = substr($request->getContent(), 0, 4);
        return $header === "PK\x03\x04";
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public static function success(array $data): array
    {
        $privateKey = Cache::remember("edith_site-private_key", 60 * 60 * 24 * 30, function () {
            return config('edith-site.private_key', null);
        });
        if (!$privateKey) {
            $privateKey = EdithAdmin::privateKey();
        }
        $rsaUtil = new Rsa(EdithAdmin::publicKey(), $privateKey);

        try {
            $key = random_bytes(32);
            $iv = random_bytes(16);
        } catch (\Exception $e) {
            throw new \Exception("Unable to generate AES key");
        }
        $encryptedData = openssl_encrypt(json_encode($data, JSON_UNESCAPED_UNICODE), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return [
            'content' => base64_encode($iv . $encryptedData),
            'headers' => [
                'Authorization' => $rsaUtil->encrypt($key),
                'X-Signature' => $rsaUtil->sign(self::buildSignContent($data)),
                'X-Timestamp' => time(),
            ]
        ];
    }

    /**
     * @param array|string $params
     * @return string
     */
    public static function buildSignContent(array|string $params): string
    {
        if (!is_array($params)) {
            $params = json_decode($params, true);
        }
        ksort($params);
        $siteCode = Cache::remember("edith_site-code", 60 * 60 * 24, function () use ($params) {
            return config('edith-site.code');
        });
        $content = [];
        if ($siteCode) {
            $content[] = $siteCode;
        }
        foreach ($params as $key => $value) {
            if (!$value && !is_numeric($value)) {
                continue;
            }
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            $content[] = $key . '=' . $value;
        }
        return implode('&', $content);
    }

    /**
     * @return string
     */
    public static function getPublicKey(): string
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'public_key.pem';
        if (!file_exists($path)) {
            abort(403, 'Public key not found.');
        }
        $publicKey = file_get_contents($path);
        $rsaKey = wordwrap($publicKey, 64, "\n", true);
        return <<<EOD
-----BEGIN PUBLIC KEY-----
$rsaKey
-----END PUBLIC KEY-----
EOD;
    }

    /**
     * @return string
     */
    public static function getPrivateKey(): string
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cert' . DIRECTORY_SEPARATOR . 'private.key';
        if (!file_exists($path)) {
            abort(403, $path . 'Private key not found.');
        }
        $privateKey = file_get_contents($path);
        $rsaKey = wordwrap($privateKey, 64, "\n", true);
        return <<<EOD
-----BEGIN PRIVATE KEY-----
$rsaKey
-----END PRIVATE KEY-----
EOD;
    }
}