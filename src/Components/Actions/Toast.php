<?php
namespace Edith\Admin\Components\Actions;

/**
 * @method $this messageType(string $type)                              success | info | waring | error
 * @method $this message(string $message)                               提示内容， 支持 ${xxx} 表达式
 */
class Toast extends Action
{
    /**
     * @var string
     */
    protected string $actionType = 'toast';
}