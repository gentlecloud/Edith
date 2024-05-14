<?php

namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithRole extends Model
{
    use DateTimeFormatter;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'name',
        'guard_name'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function permissions()
    {
        return $this->hasMany(EdithRolePermission::class, 'role_id');
    }
}
