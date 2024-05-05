<?php
namespace Gentle\Edith\Http\Middleware;

use Closure;
use Gentle\Edith\Models\EdithPlatform;
use Illuminate\Http\Request;

class Platform
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = '')
    {
        $platformId = $request->header('Edith-Platform-Id');
        if (empty($authorization)) {
            app('edith.platform')
                ->setId($platformId)
                ->setInfo(EdithPlatform::findOrFail($platformId));
        }

        return $next($request);
    }
}
