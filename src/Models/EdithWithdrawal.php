<?php
namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithWithdrawal extends Model
{
    use DateTimeFormatter, SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'examined_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'platform_id',
        'payment_id',
        'vid',
        'aid',
        'sn',
        'transaction_id',
        'order_id',
        'name',
        'tel',
        'money',
        'after_money',
        'alipay',
        'ewm',
        'status',
        'type',
        'modules',
        'examined_at'
    ];

    /**
     * 关联支付通道
     * @return mixed
     */
    public function payment()
    {
        return $this->belongsTo(EdithPayment::class, 'payment_id', 'id')->select('id', 'name', 'title');
    }
}
