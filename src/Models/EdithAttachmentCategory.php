<?php

namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithAttachmentCategory extends Model
{
    use DateTimeFormatter;

    /**
     * 属性黑名单
     *
     * @var array
     */
    protected $fillable = ['obj_type', 'obj_id', 'title', 'sort', 'description', 'status'];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
