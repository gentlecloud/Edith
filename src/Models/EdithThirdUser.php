<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithThirdUser extends Model
{
    use DateTimeFormatter;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'platform_id',
        'appid',
        'unionid',
        'openid',
        'nick_name',
        'head_img_url',
        'sex',
        'country',
        'province',
        'city',
        'tags',
        'is_black',
        'is_subscribe',
        'spread_openid',
        'spread_at',
        'qr_scene',
        'qr_scene_str',
        'subscribed_at',
        'origin',
        'channel',
        'remark',
        'refresh_token'
    ];

    /**
     * 隐藏属性
     * @var string[]
     */
    protected $hidden = ['refresh_token'];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'privilege' => 'array',
        'refresh_token' => 'array'
    ];
}
