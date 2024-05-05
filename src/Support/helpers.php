<?php

use Gentle\Edith\Widgets\Layout\Layout;
use Gentle\Edith\Widgets\Page\Content;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * 返回湛拓科技 UI 引擎
 * 
 * @author Gentle Edith <gentle@3ii.cn>
 */
if (!function_exists('engine')) {
    function engine($body, $pageBody = true): \Illuminate\Http\JsonResponse
    {
        return \Gentle\Edith\Support\Response::render($body, $pageBody);
    }
}

/**
 * 返回成功 json
 * @author Gentle Edith <gentle@3ii.cn>
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('success')) {
    function success(string $msg = 'ok~', $data = [], ?string $url = null, ?string $refresh_token = null): \Illuminate\Http\JsonResponse
    {
        $header = null;
        if (!is_null($refresh_token)) {
            $header = ['X-Refresh-Token' => $refresh_token];
        }
        return \Gentle\Edith\Support\Response::success($msg, $data, $url, $header);
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
        return \Gentle\Edith\Support\Response::error($msg, $errCode, $url);
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
        return \Gentle\Edith\Support\Response::response(-2, $errCode, $msg, null, null, null, 500);
    }
}

/**
 * 获取 Edith 配置信息
 * @author Gentle Edith <gentle@3ii.cn>
 */
if (!function_exists('edith_config')) {
    function edith_config($name , $default = '') {
        $value = \Illuminate\Support\Facades\Cache::get($name);
        if (!empty($value) && env('APP_DEBUG') !== true) {
            return $value;
        }

        $value = \Gentle\Edith\Models\EdithConfig::where('name',$name)->value('value');
        if(empty($value)) {
            $value = $default;
        }
        \Illuminate\Support\Facades\Cache::put($name, $value);
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
    function get_attachment($id, $field='path') {
        // 本身为地址，直接返回
        
        if (url()->isValidUrl($id)) {
            return $id;
        } else if(strpos($id, 'public') !== false) {
            $path = Storage::url($id);
            return env('APP_SSL',false) !== false ? secure_asset($path) : asset($path);
        }

        if (is_object($id) || !intval($id) && !is_not_json($id)) {
            $json = json_decode($id,true);
            if ($field == 'path' && isset($json['url']) && url()->isValidUrl($json['url'])) {
                return $json['url'];
            } else {
                return $json;
            }
        }

        $picture = \Gentle\Edith\Models\EdithAttachment::where('id',$id)->select('id','name','path')->first();

        // 图片存在
        if ($picture) {
            switch ($field) {
                case 'path':
                    if (url()->isValidUrl($picture['path'])) {
                        $url = $picture['path'];
                    } else {
                        $path = Storage::url($picture['path']);
                        $url = env('APP_SSL',false) !== false ? secure_asset($path) : asset($path);
                    }
                    $result = $url;
                    break;
                case 'realPath':
                    $result = url()->isValidUrl($picture['path']) ? $picture['path'] : storage_path('app/') . $picture['path'];
                    break;
                case 'all':
                    if (url()->isValidUrl($picture['path'])) {
                        $url = $picture['path'];
                    } else {
                        $path = Storage::url($picture['path']);
                        $url = env('APP_SSL', false) !== false ? secure_asset($path) : asset($path);
                    }
                    $picture['url'] = $url;
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

        return 'https://chuxin.res.huokequan.cn/pictures/o8t6ZrkWyIwL5eZigKonI65RD5nrOpsBvwyAgPag.png';
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
        $contentArray->transform(function ($item) use ($data){
            foreach ($data as $key => $value){
                if (Str::contains($item, $key)){
                    return $key . '=' . $value;
                }
            }

            return $item;
        });
        $content = implode("\n", $contentArray->toArray());
        \File::put($envPath, $content);
    }
}
