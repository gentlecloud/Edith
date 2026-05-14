<?php
declare(strict_types=1);
namespace Edith\Admin\Modules\Support;

use Edith\Admin\Exceptions\RequestErrorException;
use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Support\Http;
use Edith\Admin\Support\Rsa;
use Illuminate\Support\Facades\Cache;

final class Cloud extends Http
{
    /**
     * 翼搭 API
     * @var string
     */
    protected string $baseUrl = "https://cloud.ieda.cc/gwapi/";

    /**
     * 加密私钥
     * @var string|null
     */
    private ?string $privateKey;

    /**
     * @param string|null $privateKey
     */
    public function __construct(?string $privateKey = null)
    {
        if (is_null($privateKey)) {
            $this->privateKey = Cache::remember("edith_site-private_key", 60 * 60 * 24 * 30, function () {
                return config('edith-site.private_key', null);
            });
        } else {
            $this->privateKey = $privateKey;
        }
    }

    /**
     * @param string $url
     * @param array|string|null $data
     * @param string $method
     * @param null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function curl(string $url, array|string|null $data = null, string $method = 'GET', $callback = null): Cloud
    {
        $siteCode = Cache::remember("edith-site_code", 60 * 60 * 24 * 30, function () {
            return config("edith-site.code", null);
        });
        $dataStr = EdithCloud::buildSignContent($data);
        $signatureStr = $siteCode . $dataStr . time();
        if (empty($siteCode) && empty($this->privateKey)) {
            $signature = sha1($signatureStr);
        } else {
            $signature = (new Rsa(null, $this->privateKey))->sign($signatureStr);
        }
        $token = config('edith-site.token');
        if (!empty($token)) {
            $this->setHeader('Authorization', "Bearer " . $token);
        }
        $this->setHeader("Content-type", "application/json");
        $this->setHeader("X-Site-Code", $siteCode);
        $this->setHeader("X-Site-Host", \request()->getHost());
        $this->setHeader("X-Site-Version", EdithAdmin::version());
        $this->setHeader("X-Timestamp", strval(time()));
        $this->setHeader('X-Signature', $signature);
        $this->setHeader('X-Requested-With', "XMLHttpRequest");

        $res = parent::curl($this->baseUrl . $url, $data, $method)->toArray();
        if ($this->httpStatusCode() != 200) {
            throw new RequestErrorException("请求失败，HttpCode：" . $this->httpStatusCode(), -$this->httpStatusCode());
        }
        if (!isset($res['status']) || $res['status'] != 0) {
            $errMsg = $res['message'] ?? '未知错误.';
            throw new RequestErrorException("翼搭云端异常：{$errMsg}");
        }
        return $this;
    }
}