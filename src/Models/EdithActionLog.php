<?php
namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithActionLog extends Model
{
    use DateTimeFormatter;

    // 允许批量赋值的字段
    protected $fillable = [
        'obj_id',
        'url',
        'remark',
        'ip',
        'type',
        'method',
        'content',
        'region',
        'status'];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function admin()
    {
        return $this->hasOne('Edith\Admin\Models\EdithAdmin', 'id', 'obj_id');
    }
}
