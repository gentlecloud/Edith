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
     * 携带 Cookie
     * @var array|string|null
     */
    protected string|array|null $cookie = null;

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
     * 连接超时 单位 s
     * @var int
     */
    protected int $connect_timeout = 15;

    /**
     * 请求超时 单位 s
     * @var int
     */
    protected int $timeout = 60;

    /**
     * 响应 Body
     * @var string|null|bool
     */
    protected string|bool|null $response = null;

    /**
     * 响应 Header
     * @var string|null
     */
    protected ?string $responseHeader = null;

    /**
     * Http Status Code
     * @var int
     */
    protected int $httpCode = 200;

    /**
     * 发起 GET 请求
     * @param string $url
     * @param array|string|null $params
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function get(string $url, array|string|null $params = null, ?callable $callback = null): Http
    {
        if (!is_null($params)) {
            if (is_array($params)) {
                ksort($params);
                $content = "";
                foreach ($params as $key => $value) {
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $value)) {
                        $content .= "{$key}=" . urlencode($value) . "&";
                    } else {
                        $content .= "{$key}={$value}&";
                    }
                }
                $params = substr($content, 0, -1);
            }
            if (!str_contains($url, '?')) {
                $url .= "?{$params}";
            } else {
                $url .= "&{$params}";
            }
        }

        $this->curl($url, null, 'GET', $callback);
        if (!$this->response) {
            throw new \Exception('请求失败！');
        }
        return $this;
    }

    /**
     * Post 请求
     * @param string $url
     * @param array|null $data
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function post(string $url, ?array $data = [], ?callable $callback = null): Http
    {
        $this->curl($url, $data, 'POST', $callback);
        return $this;
    }

    /**
     * Post JSON 请求
     * @param string $url
     * @param string|array|null $data
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function postJson(string $url, string|array|null $data = null, ?callable $callback = null): Http
    {
        is_array($data) && $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $this->curl($url, $data, 'POST', $callback);
        return $this;
    }

    /**
     * PUT 请求
     * @param string $url
     * @param array|null $data
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function put(string $url, ?array $data = null, ?callable $callback = null): Http
    {
        return $this->curl($url, $data, 'PUT', $callback);
    }

    /**
     * 发起请求
     * @param string $url
     * @param array|null $parameter
     * @param string $method POST|GET
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function request(string $url, ?array $parameter = null, string $method = 'POST', ?callable $callback = null): Http
    {
        switch ($method) {
            case 'GET':
                $this->get($url, $parameter, $callback);
                break;
            case 'PUT':
                $this->put($url, $parameter, $callback);
                break;
            default:
                $this->curl($url, $parameter, $callback);
                break;
        }
        if (!$this->response) {
            throw new \Exception('请求失败！');
        }
        return $this;
    }

    /**
     * 设置页头
     * @param array|string $header
     * @param string|null $value
     * @return $this
     */
    public function header(array|string $header, ?string $value = null): Http
    {
        if (is_array($header)) {
            $this->header = $header;
        } else {
            $this->header[] = $header . ':' . $value;
        }
        return $this;
    }

    /**
     * 设置页头
     * @param array|string $header
     * @param string|null $value
     * @return $this
     */
    public function setHeader(array|string $header, ?string $value = null): Http
    {
        if (is_array($header)) {
            $this->header = $header;
        } else {
            $this->header[] = $header . ':' . $value;
        }
        return $this;
    }

    /**
     * 设置 Http 代理IP
     * @param string $proxy
     * @return $this
     */
    public function proxy(string $proxy): Http
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
    public function proxyAuth(string $username, string $password): Http
    {
        $this->proxyAuth = [
            'username' => $username,
            'password' => $password
        ];
        return $this;
    }

    /**
     * 设置连接超时时间，单位：秒
     * @param int $connect_timeout
     * @return $this
     */
    public function connectTimeout(int $connect_timeout): Http
    {
        $this->connect_timeout = $connect_timeout;
        return $this;
    }

    /**
     * 设置请求超时时间，单位：秒
     * @param int $timeout
     * @return $this
     */
    public function timeout(int $timeout): Http
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * 设置携带 Cookie
     * @param string|array $name
     * @param string|null $value
     * @return $this
     */
    public function cookie(string|array $name, ?string $value = null): Http
    {
        if (is_array($name)) {
            $this->cookie = implode(';', $name);
        } else {
            $this->cookie = "{$name}={$value}";
        }
        return $this;
    }

    /**
     * 发起 Curl 请求
     * @param string $url
     * @param array|string|null $data
     * @param string $method
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function curl(string $url, array|string|null $data = null, string $method = 'GET', ?callable $callback = null): self
    {
        $header = $this->header;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            if (is_string($data) && !$header) {
                $header = ['Content-Type: application/json'];
            }
        }

        if (count($header)) {
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

        if ($this->cookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        }

        if ($this->connect_timeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
        }

        if ($this->timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        }
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        if ($callback) {
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, $callback);
        }

        if (curl_errno($ch) === CURLE_OPERATION_TIMEDOUT) {
            curl_close($ch);
            throw new RequestErrorException('请求超时，请重试或检查服务器状态！', CURLE_OPERATION_TIMEDOUT);
        }

        if (curl_errno($ch)) {
            curl_close($ch);
            throw new RequestErrorException('curl 请求错误: ' . curl_error($ch), curl_errno($ch));
        }
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->responseHeader = substr($response, 0, $headerSize);
        $this->response = substr($response, $headerSize);
        curl_close($ch);
        return $this;
    }

    /**
     * 获取请求内容
     * @return string|null|bool
     */
    public function getResponse(): string|bool|null
    {
        return $this->response;
    }

    /**
     * 获取请求页头
     * @return string
     */
    public function getResponseHeader(): string
    {
        return $this->responseHeader;
    }

    /**
     * @return int
     */
    public function httpStatusCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @return array|null
     */
    public function toArray(): ?array
    {
        return json_decode($this->response, true);
    }
}
