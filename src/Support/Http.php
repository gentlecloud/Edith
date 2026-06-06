<?php

namespace Edith\Admin\Support;

use Edith\Admin\Exceptions\RequestErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TimeoutException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;

class Http
{
    /**
     * GuzzleHttp
     * @var Client
     */
    private Client $client;

    /**
     * 响应 Status Code
     * @var int 
     */
    private int $httpCode;

    /**
     * 响应页头
     * @var string
     */
    private string $responseHeader = '';

    /**
     * 响应 Body
     * @var string
     */
    private string $response = '';

    /**
     * 响应页头
     * @var array
     */
    private array $responseHeaders = [];

    // 配置属性
    /**
     * 请求 Header
     * @var array
     */
    private array $headers = [];

    /**
     * @var array
     */
    private array $basicAuth = [];

    /**
     * 代理信息
     * @var string|null
     */
    private ?string $proxy = null;

    /**
     * 代理授权认证
     * @var array
     */
    private array $proxyAuth = [];

    /**
     * 携带 Cookie
     * @var string|null
     */
    private ?string $cookie = null;

    /**
     * 连接超时时间
     * @var int|null
     */
    private ?int $connectTimeout = null;

    /**
     * 请求超时时间
     * @var int|null
     */
    private ?int $timeout = 60;

    /**
     * SSL 验证
     * @var bool
     */
    private bool $sslVerify = true;

    /**
     * construct Http
     */
    public function __construct()
    {
        $this->client = new Client([
            'verify' => $this->sslVerify,
            'http_errors' => false,
        ]);
    }

    /**
     * 发起 GET 请求
     * @param string $url
     * @param array|string|null $params
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function get(string $url, array|string|null $params = null, ?callable $callback = null): self
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

        $this->request($url, null, 'GET', $callback);
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
    public function post(string $url, ?array $data = [], ?callable $callback = null): self
    {
        return $this->request($url, $data, 'POST', $callback);
    }

    /**
     * Post JSON 请求
     * @param string $url
     * @param string|array|null $data
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function postJson(string $url, string|array|null $data = null, ?callable $callback = null): self
    {
        is_array($data) && $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $this->request($url, $data, 'POST', $callback);
        return $this;
    }

    /**
     * PUT 请求
     */
    public function put(string $url, $data = null, ?callable $callback = null): self
    {
        return $this->request($url, $data, 'PUT', $callback);
    }

    /**
     * DELETE 请求
     */
    public function delete(string $url, $data = null, ?callable $callback = null): self
    {
        return $this->request($url, $data, 'DELETE', $callback);
    }

    /**
     * 构建请求选项
     */
    private function buildOptions(string $method, $data, ?callable $callback): array
    {
        $options = [];

        // 设置 Headers
        if (!empty($this->headers)) {
            $options['headers'] = $this->headers;
        }

        // 设置请求体
        if ($data !== null) {
            $hasFile = false;
            if (is_array($data)) {
                $hasFile = $this->hasFile($data);
            }
            $options = $this->buildBodyOptions($options, $data, $hasFile);

            if ($hasFile) {
                $options['headers'] = array_merge($options['headers'] ?? [], [
                    'Accept' => 'application/json',
                    'Connection' => 'keep-alive'
                ]);
            }
        }

        // 设置流式响应回调
        if ($callback) {
            $options['sink'] = $callback;
        }

        // 设置 Basic Auth
        if (!empty($this->basicAuth['app_id']) && !empty($this->basicAuth['app_key'])) {
            $options['auth'] = [
                $this->basicAuth['app_id'],
                $this->basicAuth['app_key'],
                'basic'
            ];
        }

        // 设置代理
        if ($this->proxy) {
            $options['proxy'] = $this->buildProxyConfig();
        }

        // 设置 Cookie
        if ($this->cookie) {
            $options['headers']['Cookie'] = $this->cookie;
        }

        // 设置超时
        if ($this->connectTimeout) {
            $options['connect_timeout'] = $this->connectTimeout;
        }

        if ($this->timeout) {
            $options['timeout'] = $this->timeout;
        }

        // 设置编码
        $options['headers']['Accept-Encoding'] = 'gzip';

        // SSL 验证
        $options['verify'] = $this->sslVerify;

        return $options;
    }

    /**
     * 发起请求
     * @param string $url
     * @param array|string|null $data
     * @param string $method POST|GET
     * @param callable|null $callback
     * @return $this
     * @throws RequestErrorException
     */
    public function request(string $url, array|string|null $data = null, string $method = 'POST', ?callable $callback = null): self
    {
        $options = $this->buildOptions($method, $data, $callback);

        try {
            $response = $this->client->request($method, $url, $options);

            // 处理流式响应（如果有回调）
            if ($callback && $response->getBody()->isSeekable()) {
                $body = $response->getBody()->getContents();
                $callback($body);
            }

            $this->httpCode = $response->getStatusCode();
            $this->responseHeaders = $response->getHeaders();
            $this->responseHeader = $this->formatHeaders($this->responseHeaders);
            $this->response = $response->getBody()->getContents();

        } catch (TimeoutException $e) {
            throw new RequestErrorException('请求超时，请重试或检查服务器状态！', $e->getCode(), $e);
        } catch (ConnectException $e) {
            throw new RequestErrorException('连接失败：' . $e->getMessage(), $e->getCode(), $e);
        } catch (RequestException $e) {
            // 处理请求异常（如 4xx, 5xx）
            if ($e->hasResponse()) {
                $this->httpCode = $e->getResponse()->getStatusCode();
                $this->responseHeaders = $e->getResponse()->getHeaders();
                $this->responseHeader = $this->formatHeaders($this->responseHeaders);
                $this->response = $e->getResponse()->getBody()->getContents();
            }
            throw new RequestErrorException('请求错误：' . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new RequestErrorException('curl 请求错误: ' . $e->getMessage(), $e->getCode(), $e);
        }

        return $this;
    }


    /**
     * 构建请求体选项
     */
    private function buildBodyOptions(array $options, $data, $hasFile = false): array
    {
        if (is_string($data)) {
            $options['body'] = $data;

            if (!isset($this->headers['Content-Type'])) {
                $options['headers']['Content-Type'] = 'application/json';
            }
        } elseif (is_array($data)) { // 如果是数组，判断是否为文件上传
            if ($hasFile) {
                $options['multipart'] = $this->buildMultipartData($data);
            } else {
                $options['form_params'] = $data;
            }
        }

        return $options;
    }

    /**
     * 构建 multipart 数据（文件上传）
     */
    private function buildMultipartData(array $data): array
    {
        $multipart = [];

        foreach ($data as $name => $value) {
            if ($value instanceof \CURLFile) {
                // 获取正确的 MIME 类型
                $mimeType = $value->getMimeType();
                if (empty($mimeType)) {
                    // 根据文件扩展名判断
                    $extension = pathinfo($value->getFilename(), PATHINFO_EXTENSION);
                    $mimeType = $this->getMimeType($extension);
                }

                $multipart[] = [
                    'name' => $name,
                    'contents' => fopen($value->getFilename(), 'r'),
                    'filename' => basename($value->getFilename()),
                    'headers' => [
                        'Content-Type' => $mimeType ?: 'application/octet-stream',
                        'Content-Transfer-Encoding' => 'binary'
                    ]
                ];
            } elseif (is_resource($value)) {
                // 处理直接传入的资源
                $metadata = stream_get_meta_data($value);
                $multipart[] = [
                    'name' => $name,
                    'contents' => $value,
                    'filename' => basename($metadata['uri'] ?? 'file'),
                    'headers' => [
                        'Content-Type' => 'application/octet-stream',
                        'Content-Transfer-Encoding' => 'binary'
                    ]
                ];
            } else {
                $multipart[] = [
                    'name' => $name,
                    'contents' => (string) $value
                ];
            }
        }

        return $multipart;
    }

    /**
     * 构建代理配置
     */
    private function buildProxyConfig(): array
    {
        $proxy = [
            'http' => $this->proxy,
            'https' => $this->proxy,
        ];

        if (!empty($this->proxyAuth['username']) && !empty($this->proxyAuth['password'])) {
            $auth = "{$this->proxyAuth['username']}:{$this->proxyAuth['password']}";
            $proxy['http'] = str_replace('://', "://{$auth}@", $this->proxy);
            $proxy['https'] = str_replace('://', "://{$auth}@", $this->proxy);
        }

        return $proxy;
    }

    /**
     * 获取页头
     * @return array
     */
    public function header(): array
    {
        return $this->headers;
    }

    /**
     * 设置请求头
     */
    public function setHeader(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    /**
     * 添加单个请求头
     */
    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * 设置 Basic Auth
     */
    public function setBasicAuth(string $appId, string $appKey): self
    {
        $this->basicAuth = [
            'app_id' => $appId,
            'app_key' => $appKey
        ];
        return $this;
    }

    /**
     * 设置代理
     */
    public function setProxy(string $proxy, ?string $username = null, ?string $password = null): self
    {
        $this->proxy = $proxy;
        if ($username && $password) {
            $this->proxyAuth = [
                'username' => $username,
                'password' => $password
            ];
        }
        return $this;
    }

    /**
     * 设置 Cookie
     */
    public function setCookie(string $cookie): self
    {
        $this->cookie = $cookie;
        return $this;
    }

    /**
     * 设置连接超时
     */
    public function setConnectTimeout(int $seconds): self
    {
        $this->connectTimeout = $seconds;
        return $this;
    }

    /**
     * 设置请求超时
     */
    public function setTimeout(int $seconds): self
    {
        $this->timeout = $seconds;
        return $this;
    }

    /**
     * 获取 HTTP 状态码
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * 获取响应头（字符串格式）
     */
    public function getResponseHeader(): string
    {
        return $this->responseHeader;
    }

    /**
     * 获取响应头（数组格式）
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * 获取响应体
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * 获取 JSON 格式的响应
     */
    public function getJsonResponse(): mixed
    {
        return json_decode($this->response, true);
    }

    /**
     * 重置所有配置
     */
    public function reset(): self
    {
        $this->headers = [];
        $this->basicAuth = [];
        $this->proxy = null;
        $this->proxyAuth = [];
        $this->cookie = null;
        $this->connectTimeout = null;
        $this->timeout = null;
        return $this;
    }

    /**
     * 检查响应是否为 JSON 并自动解码
     */
    public function toArray(): array
    {
        $data = json_decode($this->response, true);
        return is_array($data) ? $data : [];
    }

    /**
     * 检查响应是否为 JSON 并自动解码为对象
     */
    public function toObject(): object
    {
        $data = json_decode($this->response);
        return is_object($data) ? $data : new \stdClass();
    }

    /**
     * 格式化响应头
     */
    private function formatHeaders(array $headers): string
    {
        $headerString = '';
        foreach ($headers as $name => $values) {
            $headerString .= $name . ': ' . implode(', ', $values) . "\r\n";
        }
        return $headerString;
    }

    // 辅助方法：获取 MIME 类型
    private function getMimeType(string $extension): string
    {
        $mimes = [
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            '7z' => 'application/x-7z-compressed',
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'txt' => 'text/plain',
            'json' => 'application/json',
            'xml' => 'application/xml',
        ];

        return $mimes[strtolower($extension)] ?? 'application/octet-stream';
    }

    private function hasFile(array $data): bool
    {
        foreach ($data as $value) {
            if ($value instanceof \CURLFile || is_resource($value)) {
                return true;
            }
        }
        return false;
    }
}
