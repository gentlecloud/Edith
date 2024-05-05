<?php
namespace Gentle\Edith\Support;

use Gentle\Edith\Exceptions\RequestErrorException;
use Gentle\Edith\Support\FileUtil;

class Http
{
    /**
     * 自定义页头
     * @var array
     */
    protected array $header = [];

    /**
     * 代理 IP
     * @var string|null
     */
    protected ?string $proxy;

    /**
     * 代理权限验证
     * @var array|null
     */
    protected ?array $proxyAuth = null;

    /**
     * @var string|null|bool
     */
    protected $response = null;

    /**
     * @var string|null
     */
    protected ?string $responseHeader = null;

    /**
     * 发起 GET 请求
     * @param string $url
     * @param null $params
     * @return $this
     * @throws RequestErrorException
     */
    public function get(string $url, $params = null): Http
    {
        if (!is_null($params)) {
            if (is_array($params)) {
                ksort($params);
                $content = "";
                foreach ($params as $key => $value) {
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    $content .= "{$key}={$value}&";
                }
                $params = substr($content, 0, -1);
            }
            if (strpos($url, '?') === false) {
                $url .= "?{$params}";
            } else {
                $url .= "&{$params}";
            }
        }

        $this->curl($url);
        if (!$this->response) {
            throw new RequestErrorException('请求失败！');
        }
        return $this;
    }

    /**
     * @param string $url
     * @param array|string|null $data
     * @return $this
     * @throws RequestErrorException
     */
    public function post(string $url, $data): Http
    {
        $this->request($url, $data);
        return $this;
    }

    /**
     * @param string $url
     * @param array|string|null $data
     * @return $this
     * @throws RequestErrorException
     */
    public function postJson(string $url, $data = null): Http
    {
        is_array($data) && $data = json_encode($data);
        $this->request($url, $data);
        return $this;
    }

    /**
     * 发起请求
     * @param string $url
     * @param array|string|null $parameter
     * @param string $method POST|GET
     * @return $this
     * @throws RequestErrorException
     */
    public function request(string $url, $parameter, string $method = 'POST'): Http
    {
        switch ($method) {
            case 'GET':
                $this->get($url, $parameter);
                break;
            default:
                $this->curl($url, $parameter);
                break;
        }
        if (!$this->response) {
            throw new RequestErrorException('请求失败！');
        }
        return $this;
    }

    /**
     * 设置页头
     * @param array $header
     * @return $this
     */
    public function setHeader(array $header): Http
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHeader(): ?array
    {
        return $this->header;
    }

    /**
     * 设置 Http 代理IP
     * @param string $proxy
     * @return $this
     */
    public function setProxy(string $proxy): Http
    {
        $this->proxy = $proxy;
        return $this;
    }

    /**
     * 代理验证
     * @param string $username 授权用户名
     * @param string $password 授权密码
     * @return $this
     */
    public function setProxyAuth(string $username, string $password): Http
    {
        $this->proxyAuth = [
            'username' => $username,
            'password' => $password
        ];
        return $this;
    }

    /**
     * 发起 Curl 请求
     * @param string $url
     * @param array|string|null $data
     * @param array|string|false $cookie
     * @return $this
     */
    public function curl(string $url, $data = null, $cookie = false)
    {
        $header = $this->header;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, strpos($url,'https'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, strpos($url,'https'));

        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            if (is_string($data) && !$header) {
                $header = ['Content-Type: application/json', 'User-Agent: Edith/2.0.0'];
            }
        }

        if (is_array($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if (isset($basicAuth['app_id']) && isset($basicAuth['app_key'])) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "{$basicAuth['app_id']}:{$basicAuth['app_key']}");
        }

        if (!empty($this->proxy)) {
            //设置代理
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
           if (isset($this->proxyAuth['username']) && isset($this->proxyAuth['password'])) {
               //设置代理用户名密码
               curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
               curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$this->proxyAuth['username']}:{$this->proxyAuth['password']}");
           }
        }

        if ($cookie) {
            if (is_array($cookie)) {
                $cookie = implode(';', $cookie);
            }
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->responseHeader = substr($response, 0, $headerSize);
        $this->response = substr($response, $headerSize);

        curl_close($ch);
        return $this;
    }

    /**
     * 获取请求内容
     * @return string|null|bool
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 获取请求页头
     * @return mixed
     */
    public function getResponseHeader(): array
    {
        return explode("\n", $this->responseHeader);
    }

    /**
     * @return array|null
     */
    public function toArray(): ?array
    {
        return json_decode($this->response, true);
    }

    /**
     * 获取主体内容
     * @param string $response 请求返回主体
     * @return string|null
     */
    public function getBody(string $response): ?string
    {
        if (!$response) {
            return $response;
        }
        list($header, $body) = explode("\r\n\r\n", $response, 2);
        return $body;
    }
}
