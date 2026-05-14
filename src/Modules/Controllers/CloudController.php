<?php

namespace Edith\Admin\Modules\Controllers;

use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Http\Controllers\Controller;
use Edith\Admin\Modules\Requests\SiteRegisterRequest;
use Edith\Admin\Modules\Support\Cloud;
use Edith\Admin\Modules\Support\EdithCloud;
use Edith\Admin\Support\File;
use Edith\Admin\Support\Response;
use Edith\Admin\Support\Rsa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Route;
use Modules\Core\Models\EdithModule;
use ZipArchive;

final class CloudController extends Controller
{
    /**
     * 云端接口
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function dock(Request $request)
    {
        switch ($request->get('method')) {
            case 'distribute':
                set_time_limit(0);
                ini_set('memory_limit', '1024M');
                if (!EdithCloud::isZipStream($request)) {
                    abort(415, 'Only ZIP files are allowed');
                }
                $request->validate([
                    'file' => 'file|max:51200|mimes:zip'
                ]);
                $tempDir = storage_path('temp');
                if (!is_dir($tempDir)) {
                    mkdir($tempDir, 0700, true);
                }
                $tempZipPath = "{$tempDir}/" . $request->header('X-Task-ID', uniqid()) . ".zip";
                $inputStream = fopen('php://input', 'rb');
                $zipHandle = fopen($tempZipPath, 'wb');
                while (!feof($inputStream)) {
                    fwrite($zipHandle, fread($inputStream, 8192));
                }
                fclose($inputStream);
                fclose($zipHandle);
                usleep(1500);

                $content = [
                    'file_path' => $tempZipPath
                ];
                if (file_exists($tempZipPath)) {
                    try {
                        $zip = new ZipArchive();
                        $zip->open($tempZipPath);
                        if (!empty($request->header('X-Task-Pass'))) {
                            $zip->setPassword($request->header('X-Task-Pass'));
                        }
                        $zip->extractTo(config('edith.modules.path', base_path('modules')));
                        $zip->close();
                        $content['extract'] = true;
                    } catch (\Exception $e) {
                        $content['err_msg'] = $e->getMessage();
                    } finally {
                        @unlink($tempZipPath);
                    }
                }
                break;
            case 'verify':
                if ($request->get('token')) {
                    modify_config_file('edith-site', 'token', $request->get('token'));
                }
                $content = [
                    'version' => EdithAdmin::version()
                ];
                break;
            default:
                $content = [
                    'code' => config('edith-site.code'),
                    'domain' => config('edith-site.domain'),
                ];
                break;
        }
        $content = EdithCloud::success($content);
        return Response::success("ok.", $content['content'], null, $content['headers']);
    }

    /**
     * 云环境注册
     * @param SiteRegisterRequest $request
     * @return JsonResponse
     */
    public function register(SiteRegisterRequest $request)
    {
        $data = $request->validated();

        try {
            $path = base_path('config/edith-site.php');
            $rsaInfo = (new Rsa())->generate();

            $str = "<?php\r\n/**\r\n * Edith-Cloud-Site \r\n */\r\nreturn [\r\n";
            foreach ($data as $key => $value) {
                $str .= "\t'$key' => '$value',\r\n";
            }
            $str .= "\t'private_key' => '" . $rsaInfo['private_key'] . "',\r\n";
            $str .= '];';
            file_put_contents($path, $str);

            Cache::forget('edith_cloud_dock_info');
            Cache::forget("edith_site-private_key");

            $content = EdithCloud::success([
                'server_name' => $_SERVER['SERVER_NAME'],
                'public_key' => $rsaInfo['public_key']
            ]);
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return Response::success("ok.", $content['content'], null, $content['headers']);
    }

    /**
     * 应用模块
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function modules(Request $request)
    {
        $all = app('edith.modules')->scan();
        $installed = [];
        if (class_exists(EdithModule::class)) {
            $installed = EdithModule::where('status', 1)
                ->pluck('name')
                ->toArray();
        }

        $content = EdithCloud::success(compact('installed', 'all'));
        return Response::success("ok.", $content['content'], null, $content['headers']);
    }

    /**
     * 环境权限检测
     * @param Request $request
     * @return JsonResponse
     */
    public function checkPermission(Request $request)
    {
        $mySql = Cache::remember('edith_site_sql-version', 60 * 60 * 24 * 7, function () {
            return DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
        });
        try {
            $res = (new Cloud)->postJson('site/check', [
                'laravel_version' => app()::VERSION,
                'mysql_version' => $mySql,
                'php_version' => PHP_VERSION,
                'version' => EdithAdmin::version(),
                'core_version' => class_exists(EdithModule::class) ? EdithModule::where('name', 'Core')->where('status', 1)->value('version') : '0',
                'swoole_version' => extension_loaded('swoole') && function_exists('swoole_version') ? swoole_version() : false,
                'name' => $request->get('name')
            ])->toArray();
        } catch (\Exception $e) {
            return success([
                'permission' => [
                    [
                        'permission' => '翼搭云端',
                        'requirement' => '连接失败',
                        'status' => false,
                    ]
                ],
                'err' => $e->getMessage(),
                'status' => false
            ]);
        }
        $path = $res['data']['path'];
        $status = $res['data']['status'];
        $permission = $res['data']['permission'];
        foreach ($path as $item) {
            if (!is_dir(base_path(substr($item, 1)))) {
                File::mkdirs(base_path(substr($item, 1)));
            }
            $currentStatus = File::isWritable(base_path(substr($item, 1)));
            $permission[] = [
                'permission' => $item,
                'requirement' => 'write',
                'status' => $currentStatus,
            ];
            if (!$currentStatus) {
                $status = false;
            }
        }
        return success([
            'permission' => $permission,
            'status' => $status,
            'install_core' => class_exists(EdithModule::class) ? EdithModule::where('name', 'Core')->where('status', 1)->value('version') : false,
        ]);
    }

    /**
     * 应用模块安装
     * @param Request $request
     * @return JsonResponse
     */
    public function install(Request $request)
    {
        $name = $request->get('name');
        if (empty($name)) {
            return error('参数错误。');
        }
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        try {
            $module = app('edith.modules')->findOrFail($name, true);
            $module->install();
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('安装成功.', [
            'module' => $module->getName()
        ]);
    }
}