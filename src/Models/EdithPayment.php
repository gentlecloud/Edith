<?php
namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithPayment extends Model
{
    use DateTimeFormatter, SoftDeletes;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'platform_id',
        'sp_id',
        'title',
        'name',
        'mode',
        'logo',
        'channel',
        'mch_id',
        'app_id',
        'gateway',
        'public_key',
        'private_key',
        'root_key',
        'aes_key',
        'public_cert_path',
        'app_public_path',
        'notify_url',
        'return_url',
        'is_transfer',
        'is_default',
        'is_recommend',
        'status',
        'modules'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'method' => 'array'
    ];
}
