<?php
namespace Edith\Admin\Http\Middleware;

use Closure;

/**
 *
 */
class OverrideHome
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->path() === '/' && config('edith.route.takeover_home', false) !== false) {
            $content = $response->getContent();
            // 如果是默认的 welcome 页面，替换成 SPA
            if (str_contains($content, 'Laravel') && str_contains($content, 'welcome')) {
                return response(view('edith.index'));
            }
        }

        return $response;
    }
}