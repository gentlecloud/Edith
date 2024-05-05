<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithMenu extends Model
{
    use DateTimeFormatter;

    /**
     * 属性黑名单
     * @var array
     */
    protected $guarded = [
        'permission'
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
     * 下级子路由
     * @return mixed
     */
    public function routes()
    {
        return $this->hasMany(self::class, 'pid', 'id')->where('status', 1)->select('pid', 'name', 'path', 'layout', 'status')->distinct();
    }

    /**
     * 下级子菜单
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(self::class, 'pid', 'id');
    }
}
