<?php
namespace Gentle\Edith\Core;

use Gentle\Edith\Contracts\EdithPlatformInterface;
use Gentle\Edith\Models\EdithPlatform;

class Platform implements EdithPlatformInterface
{
    /**
     * 当前应用ID
     * @var int
     */
    protected int $id = 0;

    /**
     * 当前应用信息
     * @var EdithPlatform|null
     */
    protected ?EdithPlatform $info = null;

    /**
     * 设置当前应用ID
     * @param int $id
     * @return EdithPlatformInterface
     */
    public function setId(int $id): EdithPlatformInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 获取当前应用ID
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * 设置当前应用信息
     * @param EdithPlatform $info
     * @return EdithPlatformInterface
     */
    public function setInfo(EdithPlatform $info): EdithPlatformInterface
    {
        $this->info = $info;
        return $this;
    }

    /**
     * 获取当前应用信息
     * @return EdithPlatform|null
     */
    public function info(): ?EdithPlatform
    {
        return $this->info;
    }
}