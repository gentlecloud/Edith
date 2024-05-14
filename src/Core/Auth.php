<?php
namespace Edith\Admin\Core;

use Edith\Admin\Contracts\EdithAuthInterface;
use Edith\Admin\Models\EdithAuthToken;

class Auth implements EdithAuthInterface
{
    /**
     * 当前登录 Token
     * @var string|null
     */
    protected ?string $token;

    /**
     * 管理员ID
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * 当前管理平台
     * @var int
     */
    protected int $platformId = 0;

    /**
     * 管理员信息
     * @var array
     */
    protected array $info = [];

    /**
     * 设置当前管理员Token
     * @param string $token
     * @return EdithAuthInterface
     */
    public function setToken(string $token): EdithAuthInterface
    {
        $this->token = $token;
        return $this;
    }

    /**
     * 获取当前管理员Token
     * @return string|null
     */
    public function token(): ?string
    {
        return $this->token;
    }

    /**
     * 获取当前 Token 过期时间
     * @return int|null
     */
    public function expiresTime(): ?int
    {
        return $this->info['expires'] ?? null;
    }

    /**
     * 检测 Token 是否过期
     * @param bool $refresh 是否刷新 Token 检测，若为 Refresh Token 则过期时间将提前1小时为用户刷新 Token
     * @return bool
     */
    public function tokenIsExpires(bool $refresh = false): bool
    {
        $expireTime = $this->expiresTime();
        if (is_null($expireTime)) {
            return true;
        }
        if ($refresh) {
            $expireTime -= 60 * 60;
        }
        return $expireTime <= time();
    }

    /**
     * 获取当前管理员ID
     * @return int|null
     */
    public function id(): ?int
    {
        return $this->id;
    }

    /**
     * 获取当前管理平台
     * @return int
     */
    public function platformId(): int
    {
        return $this->platformId;
    }

    /**
     * 设置当前管理员信息
     * @param array $info
     * @return $this
     */
    public function setUser(array $info): Auth
    {
        $this->id = $info['id'] ?? 0;
        $this->platformId = $info['platform_id'] ?? 0;
        $this->info = $info;
        return $this;
    }

    /**
     * 获取当前管理员信息
     * @return array
     */
    public function user(): array
    {
        return $this->info;
    }

    /**
     * 是否为超级管理员
     * @return bool
     */
    public function isSuperAdministrator(): bool
    {
        return $this->id == config('edith.auth.admin_id');
    }

    /**
     * 退出登录
     * @return void
     * @throws \Exception
     */
    public function logout(): void
    {
        $token = $this->token();
        if (!$token) {
            throw new \Exception('Token is not exists.');
        }
        EdithAuthToken::removeToken($token);
    }
}
