<?php
namespace Edith\Admin\Listeners;

use Edith\Admin\Events;

class AuthLoginAfter
{
    /**
     * @param Events\AuthLoginAfter $event
     * @return void
     */
    public function handle(Events\AuthLoginAfter $event)
    {
        $event->user->lasted_at = date('Y-m-d H:i:s');
        $event->user->save();
        $event->user->log()->create([
            'admin_id' => $event->user['id'],
            'lasted_ip' => \request()->ip()
        ]);
    }
}
