<?php
namespace Edith\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Edith\Admin\Models\EdithActionLog as LogModel;

class LogOperation
{
    public function handle($request, Closure $next, $guard = '')
    {
        $data['url'] = urldecode($_SERVER['REQUEST_URI']);
        $data['type'] = Auth::guard('manage')->guest() ? 'USER' : 'ADMIN';
        $data['obj_id'] = Auth::guard('manage')->id();
        if (auth()->user()) {
            $data['obj_id'] = auth()->user()->id;
        }

        $data['method'] = $request->method();
        $data['content'] = json_encode($request->except([
            'password',
            'token'
        ]), JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

        $data['ip'] = $request->ip();
        $ip2region = \Edith\Admin\Support\IpLocation::find($data['ip']);
        $data['region'] = is_array($ip2region) ? implode("|", $ip2region) : $ip2region;
        $data['remark'] = '';
        if ($data['type'] == 'ADMIN'){
            $data['remark'] = implode(',', app('edith.auth')->user());
        }

        LogModel::create($data);

        return $next($request);
    }
}
