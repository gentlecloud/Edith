<?php
namespace Gentle\Edith\Events;

class ConfigRendererAfter
{
    /**
     * 当前管理平台 0为系统
     * @var int
     */
    public int $platform_id = 0;

    /**
     * @var array|null
     */
    public ?array $initialValues = null;

    /**
     * 保存前回调，构造方法
     * ConfigAfter constructor.
     * @param int $platform_id
     */
    public function __construct(int $platform_id = 0) {
        $this->platform_id = $platform_id;
    }
}
