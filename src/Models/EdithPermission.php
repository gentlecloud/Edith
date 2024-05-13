<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithPermission extends Model
{
    use DateTimeFormatter;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'name',
        'uri'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * @var string[]
     */
    protected $appends = ['menu_name'];

    /**
     * @return string
     */
    public function getMenuNameAttribute()
    {
        return EdithMenu::query()->where('id', $this->menu_id)->value('name') ?: '-';
    }
}
