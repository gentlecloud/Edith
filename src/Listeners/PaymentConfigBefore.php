<?php
namespace Gentle\Edith\Listeners;

use Gentle\Edith\Events;

class PaymentConfigBefore
{
    /**
     * 系统配置前事件处理
     * @param Events\PaymentConfigBefore $event
     */
    public function handle(Events\PaymentConfigBefore $event)
    {
        $event->payments->put('alipay', [
            'name' => '支付宝',
            'fields' => ['public_key', 'private_key', 'root_key', 'aes_key', 'public_cert_path', 'app_public_path']
        ]);

        $event->payments->put('wxpay', [
            'name' => '微信支付',
            'fields' => ['mch_id', 'public_key', 'private_key']
        ]);
    }
}
