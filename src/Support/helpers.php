<?php

use Edith\Admin\Widgets\Layout\Layout;
use Edith\Admin\Widgets\Page\Content;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Log;
use Illuminate\Support\Str;

/**
 * 返回湛拓科技 UI 引擎
 * 
 * @author Gentle Edith <gentle@3ii.cn>
 */
if (!function_exists('engine')) {
    function engine($body, $pageBody = true): \Illuminate\Http\JsonResponse
    {
        return \Edith\Admin\Support\Response::render($body, $pageBody);
    }
}

/**
 * 返回成功 json
 * @author Gentle Edith <gentle@3ii.cn>
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('success')) {
    function success(string|array|object $msg = 'ok~', $data = [], ?string $url = null, ?string $refresh_token = null): \Illuminate\Http\JsonResponse
    {
        if (func_num_args() == 1) {
            if (!is_string($msg)) {
                $data = $msg;
                $msg = 'succeed.';
            }
        }
        $header = null;
        if (!is_null($refresh_token)) {
            $header = ['X-Refresh-Token' => $refresh_token];
        }
        return \Edith\Admin\Support\Response::success($msg, $data, $url, $header);
    }
}

/**
 * 返回错误 json
 * @author Gentle Edith <gentle@3ii.cn>
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('error')) {
    function error(string $msg, int $errCode = -1, ?string $url = null): \Illuminate\Http\JsonResponse
    {
        return \Edith\Admin\Support\Response::error($msg, $errCode, $url);
    }
}

/**
 * 渲染错误 json
 * @author Gentle Edith <gentle@3ii.cn>
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('failed')) {
    function failed(string $msg, int $errCode = -500): \Illuminate\Http\JsonResponse
    {
        return \Edith\Admin\Support\Response::response(-2, $errCode, $msg, null, null, null, 500);
    }
}

/**
 * 获取 Edith 配置信息
 * @author Gentle Edith <gentle@3ii.cn>
 */
if (!function_exists('edith_config')) {
    function edith_config($name, $default = '') {
        $value = \Illuminate\Support\Facades\Cache::get($name);
        if (!empty($value) && env('APP_DEBUG') !== true) {
            return $value;
        }

        $value = \Edith\Admin\Models\EdithConfig::where('name', $name)->value('value');
        if (empty($value)) {
            $value = $default;
        } else {
            \Illuminate\Support\Facades\Cache::put($name, $value, 60 * 60 * 24 * 30);
        }
        return $value;
    }
}

/**
 * 获取 Edith Ui 跳转地址
 * @param string $api 默认控制台
 * @param bool $isEngineUrl 是否 ui 引擎
 * @author Gentle Edith <gentle@3ii.cn>
 */
if (!function_exists('edith_ui')) {
    function edith_ui(string $api = '/dashboard', $isEngineUrl = true): string
    {
        if (Str::startsWith($api,['api/']) !== false){
            $api = Str::replaceFirst('api/','',$api);
        }
        if ($isEngineUrl) {
            $url = '/index?page='.$api;
        } else {
            $url = $api;
        }
        return $url;
    }
}


if (!function_exists('module_path')) {
    function module_path(string $name, string $path = ''): string
    {
        $module = app('edith.modules')->findOrFail($name);
        return $module->getPath() . "/$path";
    }
}

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     * @param string $path
     * @return string
     */
    function config_path(string $path = ''): string
    {
        return base_path('config') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     * @param string $path
     * @return string
     */
    function public_path(string $path = ''): string
    {
        return app()->make('path.public') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
    }
}

/**
 * 获取附件存储路劲
 * @author Gentle Edith <gentle@3ii.cn>
 */
if(!function_exists('get_attachment')) {
    function get_attachment(string|int|array|null $id, string $field = 'path') {
        // 本身为地址，直接返回
        if (empty($id) || url()->isValidUrl($id)) {
            return $id;
        } else if (str_contains($id, 'public')) {
            $path = Storage::url(ltrim($id, DIRECTORY_SEPARATOR));
            return !intval(edith_config('WEB_SITE_SSL', 0)) ? secure_asset($path) : asset($path);
        }

        if (is_object($id) || !is_numeric($id) && is_json($id)) {
            $json = json_decode($id,true);
            if ($field == 'path' && isset($json['url']) && url()->isValidUrl($json['url'])) {
                return $json['url'];
            } else {
                return $json;
            }
        }
        $picture = \Edith\Admin\Models\EdithAttachment::where('id', $id)->orWhere('path', $id)->select('id', 'name', 'path')->first();

        // 图片存在
        if ($picture) {
            switch ($field) {
                case 'path':
                    if (url()->isValidUrl($picture['path'])) {
                        $url = $picture['path'];
                    } else {
                        $path = Storage::url(ltrim($picture['path'], '/'));
                        $url = !intval(edith_config('WEB_SITE_SSL', 0)) ? secure_asset($path) : asset($path);
                    }
                    $result = $url;
                    break;
                case 'realPath':
                    $result = url()->isValidUrl($picture['path']) ? $picture['path'] : storage_path('app/') . ltrim($picture['path'], '/');
                    break;
                case 'all':
                    if (url()->isValidUrl($picture['path'])) {
                        $picture['url'] = $picture['path'];
                    } else {
                        $path = Storage::url(ltrim($picture['path'], '/'));
                        $picture['url'] = !intval(edith_config('WEB_SITE_SSL', 0)) ? secure_asset($path) : asset($path);
                    }
                    $result = $picture;
                    break;
                default:
                    $result = $picture[$field];
                    break;
            }
            return $result;
        }

        if ($field == 'all') {
            return null;
        }

        return 'https://oss.res.gentle.org.cn/attachments/uLkjvbpVmisfo8NjXLs7pyUOvoBZtRR4EAlj2J2H.png';
    }
}

/**
 * 把返回的数据集转换成Tree
 * @param array|object $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 */
if (!function_exists('list_to_tree')) {
    function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0): array
    {
        // 如果是对象则转换为数组
        $list = json_decode(json_encode($list),true);
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}

/**
 * 判断字符串是否为 JSON
 */
if (!function_exists('is_json')) {
    function is_json($str): bool
    {
        if (!is_string($str)) {
            return false;
        }
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

/**
 * 改变env文件
 * @params array $data
 */

if (!function_exists('modify_env')) {
    function modify_env(array $data)
    {
        $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';
        $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

        $fieldArray = [];
        $contentArray->transform(function ($item) use ($data, &$fieldArray) {
            foreach ($data as $key => $value){
                if (Str::contains($item, $key)){
                    $fieldArray[] = $key;
                    return $key . '=' . $value;
                }
            }
            return $item;
        });
        foreach ($data as $key => $value){
            if (!in_array($key, $fieldArray)){
                $contentArray->push($key . '=' . $value);
            }
        }
        $content = implode("\n", $contentArray->toArray());
        File::put($envPath, $content);
    }
}

if (!function_exists('modify_config_file')) {
    function modify_config_file(string $name, array|string $key, string|array|null $value = null) {
        $path = config_path(str_ends_with($name, '.php') ? $name : "{$name}.php");
        $config = include $path;

        // 更新配置数组
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $config[$k] = $v;
            }
        } else {
            $config[$key] = $value;
        }
        // 写入文件
        $content = '<?php return ' . var_export($config, true) . ';';

        $content = str_replace('array (', '[', $content);
        $content = preg_replace('/\)(\s*;\s*$)/', ']$1', $content);
        File::put($path, $content);
    }
}
