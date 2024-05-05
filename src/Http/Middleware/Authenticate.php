<?php
namespace Gentle\Edith\Http\Middleware;

use Closure;
use Gentle\Edith\Exceptions\AuthenticationException;
use Gentle\Edith\Models\EdithAdmin;
use Gentle\Edith\Models\EdithAuthToken;
use Gentle\Edith\Models\EdithPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authenticate
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = '')
    {
        if ($this->shouldPassThrough($request)) {
            return $next($request);
        }
        $retHeader = [
            "Access-Control-Expose-Headers" => "X-Redirect-Engine",
            "X-Redirect-Engine" => "edith/auth/login"
        ];
        // 得到认证凭据
        $authorization = $request->header('Authorization');
        if (empty($authorization)) {
            abort(401, 'Unauthenticated.', $retHeader);
        }

        $authorizations = explode(' ',$authorization);
        if (count($authorizations) != 2 || $authorizations[0] != 'Bearer') {
            abort(401, 'Unauthenticated.', $retHeader);
        }

        $token = base64_decode($authorizations[1]);
        if (empty($token) || !($info = EdithAuthToken::findToken($token))) {
            abort(401, 'Unauthenticated.', $retHeader);
        }

        if ($info['expires'] <= time()){
            EdithAuthToken::where('expires', '<=', time())->delete();
            abort(401, 'Token has expired.', $retHeader);
        }

        $admin = EdithAdmin::with('platforms')->where('id', $info['id'])->first();
        if (!$admin || $admin['status'] != 1) {
            abort(401, 'The account does not exist or has been disabled.', $retHeader);
        }

        if ($admin['id'] != config('edith.auth.admin_id', 1) && !$this->shouldUserPassThrough($request, $admin)) {
            abort(401, 'Not permission.', $retHeader);
        }
        
        if (!empty($info['platform_id'])) {
//            if ($admin['platform_id'] != $info['platform_id'] || $admin['id'] != config('edith.auth.admin_id', 1)) {
//                abort(401, "Not permission.", $retHeader);
//            }
            app('edith.platform')->setId($info['platform_id'])->setInfo(EdithPlatform::findOrFail($info['platform_id']));
        }

        app('edith.auth')
            ->setToken($token)
            ->setUser(array_merge($info, ['pid' => $admin['pid']]));

        app('auth')->guard('manage')->setUser($admin);

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldPassThrough(Request $request) : bool
    {
        // 下面这些路由不验证权限
        $excepts = array_merge(config('edith.auth.excepts', []), [
            'auth/login',
            'auth/logout',
            'auth/query'
        ]);

        return collect($excepts)
            ->contains(function ($except) use ($request) {
                if ($except !== '/') {
                    $except = trim($except, '/');
                }
                return $request->is($except);
            });
    }

    /**
     * Determine if the request has a URI that User should pass through verification.
     * @param Request $request
     * @param EdithAdmin $admin
     * @return bool
     */
    protected function shouldUserPassThrough(Request $request, EdithAdmin $admin) : bool
    {
        $semis = array_merge(config('edith.auth.semi_permissions',[]), []);
        return collect($semis)
            ->contains(function ($semi) use ($request, $admin) {
                if ($semi !== '/') {
                    $semi = trim($semi, '/');
                }
                if ($request->is($semi)) {
                    return true;
                }
                return $admin->can(Route::currentRouteName());
            });
    }
}
