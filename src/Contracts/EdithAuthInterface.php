<?php
namespace Gentle\Edith\Contracts;

interface EdithAuthInterface
{
    /**
     * 设置当前管理费访问 Token
     * @param string $token
     * @return EdithAuthInterface
     */
    public function setToken(string $token): EdithAuthInterface;

    /**
     * 获取当前管理员 Token
     * @return string|null
     */
    public function token(): ?string;

    /**
     * 获取当前 Token 过期时间
     * @return int|null
     */
    public function expiresTime(): ?int;

    /**
     * 检测 Token 是否过期
     * @param bool $refresh 是否刷新 Token 检测，若为 Refresh Token 则过期时间将提前1小时为用户刷新 Token
     * @return bool
     */
    public function tokenIsExpires(bool $refresh = false): bool;

    /**
     * 获取当前管理员ID
     * @return int|null
     */
    public function id(): ?int;

    /**
     * 获取当前管理员绑定租户平台ID
     * @return int
     */
    public function platformId(): int;

    /**
     * 设置当前登录管理员
     * @param array $info
     * @return EdithAuthInterface
     */
    public function setUser(array $info): EdithAuthInterface;

    /**
     * 获取当前登录管理员
     * @return array
     */
    public function user(): array;

    /**
     * 当前管理员是否未超级管理员
     * @return bool
     */
    public function isSuperAdministrator(): bool;

    /**
     * 退出登录
     * @return void
     */
    public function logout(): void;
}