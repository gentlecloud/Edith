<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gentle\Edith\Traits\DateTimeFormatter;

/**
 * 平台模型
 * @package App\Models
 */
class EdithPlatformWechat extends Model
{
    use SoftDeletes, DateTimeFormatter;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'id',
        'platform_id',
        'type',
        'name',
        'logo',
        'app_id',
        'secret',
        'email',
        'gh_id',
        'token',
        'aes_key',
        'oauth_url',
        'status',
        'remark'
    ];
}
