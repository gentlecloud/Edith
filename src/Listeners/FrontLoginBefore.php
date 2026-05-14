<?php
namespace Edith\Admin\Listeners;

use Edith\Admin\Components\Displays\Iconfont;
use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Events;

class FrontLoginBefore
{
    /**
     * @param Events\FrontLoginBefore $event
     * @return void
     */
    public function handle(Events\FrontLoginBefore $event)
    {
        $basicFields = [
            (new Field('username'))
                ->id('username')
                ->placeholder('用户名')
                ->size('large')
                ->prefix(new Iconfont('icon-shouye1')),
            (new Field('password'))->placeholder('登录密码')
                ->component('password')
                ->size('large')
                ->prefix(new Iconfont('icon-password'))
//                ->fillRules($this->rules, $this->messages)
        ];
        $event->fields = $event->fields->merge($basicFields);
    }
}
