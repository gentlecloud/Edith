<?php

namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithConfig extends Model
{
    use DateTimeFormatter;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'id', 'title', 'type', 'name', 'group_name', 'value', 'remark', 'status'
    ];
}
