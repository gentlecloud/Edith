<?php
namespace Edith\Admin\Listeners;

use Edith\Admin\Events;
use Edith\Admin\Exceptions\AuthException;
use Edith\Admin\Support\Captcha;
use Illuminate\Http\JsonResponse;

class AuthLoginBefore
{
    /**
     * @param Events\AuthLoginBefore $event
     * @return void
     * @throws AuthException
     */
    public function handle(Events\AuthLoginBefore $event)
    {
        $captcha = $event->request->post('captcha');
        if (edith_config('LOGIN_CAPTCHA') == '1' && $event->request->post('mode', 'captcha') == 'captcha' && (empty($captcha) || !(new Captcha)->verify($event->request->input('uuid'), $captcha))) {
            throw new AuthException('验证码错误.');
        }
    }
}
