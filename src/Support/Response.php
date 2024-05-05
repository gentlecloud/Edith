<?php
namespace Gentle\Edith\Support;

use Gentle\Edith\Components\Amis\Page;
use Gentle\Edith\Components\Pages\PageContainer;

/**
 * Edith Response
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Response
{
    /**
     * 渲染翼搭 UI Json
     * @param array|object|string $body
     * @param string|bool|null $pageBody 内容是否自动包裹 Page
     * @return mixed
     */
    public static function render($body = null, $pageBody = true)
    {
        if (is_string($pageBody)) {
            $body = new PageContainer($pageBody, $body);
        } else if ($pageBody) {
            $body = (new Page)->body($body);
        }
        return response()->json([
            'data' => $body,
            'status' => 0,
            'msg' => 'renderer.'
        ]);
    }

    /**
     * 返回成功信息
     * @param string $msg 处理描述
     * @param object|array|string|null $data 成功处理后的 Data
     * @param string|null $url 返回 Url 或当前路由
     * @param array|null $headers 响应页头
     * @return mixed
     */
    public static function success(string $msg = 'ok.', $data = [], ?string $url = null, ?array $headers = null)
    {
        return self::response(0, 0, $msg, $data, $url, $headers);
    }

    /**
     * 返回错误信息
     * @param string $msg 错误描述
     * @param int $errCode 错误码
     * @param string|null $url 返回 Url 或当前路由
     * @return mixed
     */
    public static function error(string $msg, int $errCode = -1, ?string $url = null)
    {
        return self::response(200, $errCode, $msg, null, $url);
    }

    /**
     * 返回客户端 JSON
     * @param int $status 状态 0 | -1
     * @param int $errCode 错误码 0 | (int)
     * @param string $msg 消息描述
     * @param array|object|string|null $data 返回 Data
     * @param string|null $url 返回 Url 或当前路由
     * @param array|null $headers 响应页头
     * @param int $statusCode 响应状态码
     * @return mixed
     */
    public static function response(int $status = 0, int $errCode = 0, string $msg = 'ok.', $data = null, ?string $url = null, ?array $headers = null, int $statusCode = 200)
    {
        is_null($url) && $url = str_contains(url()->current(), 'manage') ? url()->current() : $url;
        $content = [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'url' => $url
        ];
        if (app('edith.auth')->id() && !isset($headers['X-Refresh-Token']) && app('edith.auth')->tokenIsExpires()) {
            $headers['X-Refresh-Token'] = base64_encode(auth('manage')->user()->createToken(app('edith.auth')->platformId()));
        }
        if (is_array($headers)) {
            $allows = [];
            $isCustom = false;
            foreach ($headers as $key => $value) {
                if (strtolower($key) == 'access-control-expose-headers') {
                    $isCustom = true;
                    break;
                }
                $allows[] = $key;
            }
            if (!$isCustom) {
                $headers["Access-Control-Expose-Headers"] = implode(",", $allows);
            }

        }

        if ($status != 0) {
            $content['errorCode'] = $errCode;
            $content['errorMessage'] = $msg;
            $content['data'] = null;
        }

        return response()->json($content, $statusCode)->withHeaders($headers ?: []);
    }
}