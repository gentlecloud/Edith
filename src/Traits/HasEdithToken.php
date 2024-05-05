<?php
namespace Gentle\Edith\Traits;

use Gentle\Edith\Models\EdithAuthToken;
use Gentle\Edith\Support\Rsa;

trait HasEdithToken
{

    /**
     * 获取创建新 Token
     * @param int $platform_id 当前管理子平台ID
     * @return string
     */
    public function createToken(int $platform_id = 0): string
    {
        $util = new Rsa(config('edith.rsa.public_key', env("RSA_PUBLIC_KEY")), config('edith.rsa.private_key', env("RSA_PRIVATE_KEY")));
        $token = $util->encrypt(json_encode(['id' => $this->id, 'platform_id' => $platform_id, 'username' => $this->username, 'nickname' => $this->nickname, 'create_time' => time()]));
        try {
            EdithAuthToken::create([
                'type' => 'ADMIN',
                'uid' => $this->id,
                'token' => $token,
                'expires' => time() + 60 * 60 * config('layout.valid_time', 12)
            ]);
        } catch (\Exception $e) {
            $token = $e->getMessage();
        }
        return base64_encode($token);
    }
}
