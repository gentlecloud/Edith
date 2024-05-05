<?php

namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithPay extends Model
{
    use DateTimeFormatter, SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'platform_id', 
        'user_id', 
        'out_trade_no', 
        'transaction_id', 
        'title', 
        'price', 
        'amount', 
        'refund_amount', 
        'openid', 
        'payment_id',
        'payment_code',
        'hook', 
        'hook_params',
        'status',
        'modules',
        'paid_at'
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
