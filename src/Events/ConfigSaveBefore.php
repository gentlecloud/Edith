<?php
namespace Gentle\Edith\Events;

class ConfigSaveBefore
{
    /**
     * @var array
     */
    public array $data = [];

    /**
     * 构造方法
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
}
