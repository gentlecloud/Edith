<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithRoleUser extends Model
{
    use DateTimeFormatter;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'role_id',
        'user_id'
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
     * 获取用户所有权限
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(EdithPermission::class, EdithRolePermission::class, 'role_id', 'permission_id');
    }
}
