<?php
namespace Edith\Admin\Support;

use Edith\Admin\Exceptions\RequestErrorException;

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
     * @var array|null
     */
    protected ?array $basicAuth = null;

    /**
     * @var array
     */
    protected array $cookie = [];

    /**
     * @var string|null|bool
     */
    protected string|bool|null $response = null;

    /**
     * @var string|null
     */
    protected ?string $responseHeader = null;

    /**
     * @var int
     */
    protected int $statusCode = 200;

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
            if (!str_contains($url, '?')) {
                $url .= "?{$params}";
            } else {
                $url .= "&{$params}";
            }
        }

        $this->request($url, null);
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
    public function post(string $url, array|string|null $data): Http
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
    public function postJson(string $url, array|string|null $data = null): Http
    {
        $this->setHeader('Content-Type', 'application/json; charset=utf-8');
        is_array($data) && $data = json_encode($data, JSON_UNESCAPED_UNICODE);
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
    public function request(string $url, array|string|null $parameter = null, string $method = 'POST'): Http
    {
        switch ($method) {
            case 'GET':
                $this->get($url, $parameter);
                break;
            default:
                $this->curl($url, $parameter, $method);
                break;
        }
        if (!$this->response) {
            throw new RequestErrorException('请求失败！');
        }
        return $this;
    }

    /**
     * 设置页头
     * @param array|string $header
     * @param string|null $value
     * @return $this
     */
    public function setHeader(array|string $header, string|null $value = null): Http
    {
        if (is_array($header)) {
            $this->header = $header;
        } else {
            $this->header[] = "{$header}: {$value}";
        }
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
     * @param string $app_id
     * @param string $app_key
     * @return $this
     */
    public function setAuth(string $app_id, string $app_key): Http
    {
        $this->basicAuth = [
            'app_id' => $app_id,
            'app_key' => $app_key
        ];
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setCookie(string $name, string $value): Http
    {
        $this->cookie[$name] = $value;
        return $this;
    }

    /**
     * @param array $cookies
     * @return $this
     */
    public function setCookies(array $cookies): Http
    {
        $this->cookie = $cookies;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * 发起 Curl 请求
     * @param string $url
     * @param array|string|null $data
     * @param string $method
     * @return $this
     */
    public function curl(string $url, array|string|null $data = null, string $method = 'GET'): Http
    {
        $header = $this->header;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if (strtoupper($method) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        }

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            if (is_string($data) && !$header) {
                $header = ['Content-Type: application/json', 'User-Agent: Edith/2.0.0'];
            }
        }

        if (count($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HEADER, true);
        }

        if (isset($this->basicAuth['app_id']) && isset($this->basicAuth['app_key'])) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->basicAuth['app_id']}:{$this->basicAuth['app_key']}");
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

        if (count($this->cookie)) {
            $cookies = [];
            foreach ($this->cookie as $name => $value) {
                $cookies[] = "{$name}={$value}";
            }
            curl_setopt($ch, CURLOPT_COOKIE, implode(';', $cookies));
        }

        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->responseHeader = substr($response, 0, $headerSize);
        $this->response = substr($response, $headerSize);
        $this->statusCode = $statusCode;
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
}
