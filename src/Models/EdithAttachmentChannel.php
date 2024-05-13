<?php
namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithAttachmentChannel extends Model
{
    use DateTimeFormatter;

    /**
     * 属性白名单
     * @var string[]
     */
    protected $fillable = [
        'platform_id',
        'channel_type',
        'access_id',
        'access_secret',
        'endpoint',
        'bucket',
        'domain',
        'status',
        'remark'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
