<?php
namespace Gentle\Edith\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Gentle\Edith\Traits\DateTimeFormatter;

class EdithFinance extends Model
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
    protected $guarded = [];
}
