<?php
namespace Edith\Admin\Support;

use Edith\Admin\Components\Amis\Page;
use Edith\Admin\Components\Pages\PageContainer;
use Edith\Admin\Support\Database\Helper;

/**
 * Edith Response
 * @author Chico, Xiamen Gentle Technology Co., Ltd
 */
class Response
{
    /**
     * 渲染翼搭 UI Json
     * @param array|object|string|null $body
     * @param string|bool|null $pageBody 内容是否自动包裹 Page
     * @return mixed
     */
    public static function render(array|object|string|null $body = null, string|bool|null $pageBody = true)
    {
        if ($pageBody && !($body instanceof PageContainer)) {
            $body = new PageContainer(null, $body);
        }
        $data = [
            'data' => $body,
            'status' => 0,
            'message' => 'renderer.'
        ];
        if (env('APP_DEBUG') == true) {
            $data['_sql'] = Helper::records();
        }
        return \response()->json($data);
    }

    /**
     * 返回成功信息
     * @param array|string|object $msg 处理描述
     * @param array|string|object|null $data 成功处理后的 Data
     * @param string|null $url 返回 Url 或当前路由
     * @param array|null $headers 响应页头
     * @return mixed
     */
    public static function success(string|array|object $msg = 'ok.', array|string|object|null $data = [], ?string $url = null, ?array $headers = null)
    {
        switch (func_num_args()) {
            case 1:
                if (!is_string($msg)) {
                    $data = $msg;
                    $msg = 'succeed.';
                }
                break;
        }
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
     * @param array|string|object|null $data 返回 Data
     * @param string|null $url 返回 Url 或当前路由
     * @param array|null $headers 响应页头
     * @param int $statusCode 响应状态码
     * @return mixed
     */
    public static function response(int $status = 0, int $errCode = 0, string $msg = 'ok.', object|string|array|null $data = null, ?string $url = null, ?array $headers = null, int $statusCode = 200)
    {
        $content = [
            'status' => $status,
            'message' => $msg,
            'data' => $data
        ];
        if (app('edith.auth')->id() && !isset($headers['X-Refresh-Token']) && app('edith.auth')->tokenIsExpires(true)) {
            $headers['X-Refresh-Token'] = auth('manage')->user()->createToken(app('edith.auth')->platformId());
        }
        if ($url) {
            $content['url'] = $url;
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

        if ($status != 0 && $statusCode == 200) {
            $content['errorCode'] = $errCode;
            $content['errorMessage'] = $msg;
            $content['data'] = null;
        }

        if (env('APP_DEBUG') == true) {
            $content['_sql'] = Helper::records();
        }

        return response()->json($content, $statusCode)->withHeaders($headers ?: []);
    }

    /**
     * @param string $message
     * @param array|object|null $data
     * @param int $errCode
     * @param array|null $headers
     * @param int $statusCode
     * @return mixed
     */
    public static function failed(string $message, array|object|null $data = null, int $errCode = -1, ?array $headers = [], int $statusCode = 500)
    {
        return response()->json([
            'code' => $errCode,
            'status' => -1,
            'message' => $message,
            'data' => $data
        ], $statusCode)->withHeaders($headers ?: []);
    }
}