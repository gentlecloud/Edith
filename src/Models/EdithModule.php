<?php

namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithModule extends Model
{
    use DateTimeFormatter;

    /**
     * 属性黑名单
     * @var array
     */
    protected $fillable = [
        'name',
        'title',
        'description',
        'author',
        'website',
        'status',
        'mode',
        'version',
        'priority',
        'expired_at'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
