<?php
namespace Gentle\Edith\Contracts;

use Gentle\Edith\Models\EdithPlatform;

interface EdithPlatformInterface
{
    /**
     * 获取当前租户平台
     * @return int
     */
    public function id(): int;

    /**
     * 设置当前租户平台信息
     * @param int $id
     * @return EdithPlatformInterface
     */
    public function setId(int $id): EdithPlatformInterface;

    /**
     * 设置当前访问租户平台
     * @param EdithPlatform $info
     * @return EdithPlatformInterface
     */
    public function setInfo(EdithPlatform $info): EdithPlatformInterface;

    /**
     * 获取当前访问租户平台
     * @return EdithPlatform|null
     */
    public function info(): ?EdithPlatform;
}