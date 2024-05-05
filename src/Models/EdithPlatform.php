<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithPlatform extends Model
{
    use DateTimeFormatter, SoftDeletes;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'name',
        'logo',
        'status',
        'remark'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    protected $appends = ['admin_name'];

    public function getAdminNameAttribute(){
        return EdithAdmin::where('id', $this->admin_id)->value('nickname');
    }
}
