<?php
namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Support\Rsa;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithAuthToken extends Model
{
    use DateTimeFormatter;

    /**
     * 属性黑名单
     * @var array
     */
    protected $fillable = ['type', 'uid', 'token', 'expires'];

    /**
     * 序列化字段
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Find the token instance matching the given token.
     * @param string $token
     * @return array|bool
     */
    public static function findToken(string $token): array|bool
    {
        $info = static::where('token', $token)
            ->where(function ($query) {
                $query->where('expires', '>=', time())->orWhereNull('expires')->orWhere('expires', '0');
            })
            ->first();
        if (!$info){
            return false;
        }
        $userInfo = (new Rsa(config('edith.rsa.public_key', env("RSA_PUBLIC_KEY")), config('edith.rsa.private_key', env("RSA_PRIVATE_KEY"))))->decrypt($token);
        if ($userInfo) {
            $userInfo = array_merge(json_decode($userInfo,true), ['expires' => $info['expires']]);
        }
        return $userInfo;
    }

    /**
     * 退出登录 设置Token状态
     * @param string $token
     * @return mixed
     */
    public static function removeToken(string $token)
    {
        return static::where('token', $token)->delete();
    }
}
