<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithRolePermission extends Model
{
    use DateTimeFormatter;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'role_id',
        'permission_id'
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
     * the Role has and belongs to many permission.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions() : HasMany
    {
        return $this->hasMany(EdithPermission::class,'id','permission_id');
    }
}
