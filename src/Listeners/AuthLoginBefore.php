<?php
namespace Edith\Admin\Listeners;

use Edith\Admin\Events;
use Edith\Admin\Exceptions\AuthException;
use Illuminate\Support\Facades\Cache;

class AuthLoginBefore
{
    /**
     * @param Events\AuthLoginBefore $event
     * @return void
     * @throws AuthException
     */
    public function handle(Events\AuthLoginBefore $event)
    {
        if (($username = $event->request->get('username'))) {
            $maxNum = config('edith.auth.fail_num', 5);
            $errNum = Cache::get("manage_user_fail_{$username}");
            if ($errNum && $errNum >= $maxNum) {
                throw new AuthException("登录失败次数过多，请5分钟后再试");
            }
        }
    }
}
