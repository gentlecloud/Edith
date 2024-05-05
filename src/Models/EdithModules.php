<?php
namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithModules extends Model
{
    use DateTimeFormatter;

    /**
     * 表属性白名单
     * @var array
     */
//    protected $fillable = [];
    protected $guarded = [];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function enabled(): bool
    {
        return $this->status === 1;
    }
}