<?php
declare(strict_types=1);
namespace Edith\Admin\Support;

use Edith\Admin\Exceptions\RequestErrorException;
use Edith\Admin\Facades\EdithAdmin;
use Illuminate\Support\Facades\Cache;

class Cloud extends Http
{
    protected string $baseUrl = "https://cloud.ieda.cc/gwapi/";

    /**
     * @param string $url
     * @param array|string|null $data
     * @param string $method
     * @return $this
     * @throws RequestErrorException
     */
    public function curl(string $url, array|string|null $data = null, string $method = 'GET'): Cloud
    {
        $siteCode = Cache::remember("edith-site_code", 60 * 60 * 24 * 30, function () {
            return config("edith-site.code", null);
        });
        $signatureStr = $siteCode . (is_string($data) ? $data : json_encode($data, JSON_UNESCAPED_UNICODE)) . time();
        if (empty($siteCode)) {
            $signature = sha1($signatureStr);
        } else {
            $privateKey = Cache::remember("edith-site-private_key", 60 * 60 * 24 * 30, function () {
                return config('edith-site.private_key', null);
            });
            $signature = (new Rsa(null, $privateKey))->sign($signatureStr);
        }
        $this->setHeader("X-Site-Code", $siteCode);
        $this->setHeader("X-Site-Host", \request()->getHost());
        $this->setHeader("X-Site-Version", EdithAdmin::version());
        $this->setHeader("X-Timestamp", strval(time()));
        $this->setHeader('X-Signature', $signature);
        $this->setHeader('X-Requested-With', "XMLHttpRequest");
        $res = parent::curl($this->baseUrl . $url, $data, $method)->toArray();
        if (!isset($res['status']) || $res['status'] != 0) {
            throw new RequestErrorException("翼搭云端异常：{$res['message']}");
        }
        return $this;
    }
}