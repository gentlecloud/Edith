<?php

namespace Edith\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Edith\Admin\Traits\DateTimeFormatter;

class EdithAttachmentUse extends Model
{
    use DateTimeFormatter;

    /**
     * 属性黑名单
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'attachment_id',
        'model',
        'model_id'
    ];
}
