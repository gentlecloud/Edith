<?php
namespace Edith\Admin\Modules\Middleware;

use Closure;
use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Modules\Support\EdithCloud;
use Edith\Admin\Support\Rsa;
use Illuminate\Support\Facades\Cache;

final class Cloud
{
    public function handle($request, Closure $next, $guard = '')
    {
        $timestamp = intval($request->header('X-Timestamp', 0));
        if (microtime(true) - $timestamp >= 60 * 5) {
            abort(403, 'Timestamp has expired.');
        }

        // 得到认证凭据
        $token = $request->header('Authorization');
        if (empty($token)) {
            abort(401, 'Unauthenticated.');
        }

        $privateKey = Cache::remember("edith_site-private_key", 60 * 60 * 24 * 30, function () {
            return config('edith-site.private_key', null);
        });
        if (!$privateKey) {
            $privateKey = EdithAdmin::privateKey();
        }
        $rsaUtil = new Rsa(EdithAdmin::publicKey(), $privateKey);
        if ($request->isJson()) {
            $postData = $request->getContent();

            $combined = base64_decode($postData);
            $iv = substr($combined, 0, 16);
            $encrypted = substr($combined, 16);
            $postData = openssl_decrypt($encrypted, 'aes-256-cbc', $rsaUtil->decrypt($token), OPENSSL_RAW_DATA, $iv);
            if (!$postData) {
                $postData = $request->post();
            } else {
                $postData = json_decode($postData, true);
                if (is_array($postData)) {
                    $request->merge($postData);
                }
            }
        } else {
            $postData = $request->input();
        }
        if (!$rsaUtil->verify(EdithCloud::buildSignContent($postData), $request->header('X-Signature'))) {
            abort(403, 'Signature verification failed.');
        }
        return $next($request);
    }
}
