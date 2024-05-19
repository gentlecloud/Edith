<?php

namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithSetting extends Model
{
    use DateTimeFormatter;

    /**
     * @var string
     */
    protected $primaryKey = 'flag';

    /**
     * 属性黑名单
     * @var array
     */
    protected $fillable = [
        'flag',
        'value'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'value' => 'json'
    ];
}
