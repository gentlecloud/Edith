<?php
namespace Gentle\Edith\Listeners;

use Gentle\Edith\Events;
use Gentle\Edith\Exceptions\AuthException;
use Gentle\Edith\Support\Captcha;
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
