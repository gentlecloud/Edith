<?php
namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithAdminLogin extends Model
{
    use DateTimeFormatter;

    protected $fillable = ['admin_id', 'province', 'city', 'ip_info', 'lasted_ip', 'lasted_at'];   //允许批量赋值的字段

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

}
