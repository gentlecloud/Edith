<?php
namespace Edith\Admin\Http\Middleware;

use Closure;

class Platform
{
    public function handle($request, Closure $next, $guard = '')
    {

        return $next($request);
    }
}
