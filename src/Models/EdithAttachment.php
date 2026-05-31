<?php
namespace Edith\Admin\Models;

use Edith\Admin\Traits\DateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EdithAttachment extends Model
{
    use DateTimeFormatter;

    /**
     * 属性白名单
     * @var array
     */
    protected $fillable = [
        'id',
        'channel_id',
        'platform_id',
        'obj_type',
        'obj_id',
        'category_id',
        'name',
        'size',
        'width',
        'height',
        'ext',
        'mime',
        'path',
        'url',
        'md5',
        'driver',
        'upload_ip'
    ];

    /**
     * 时间序列化
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * 增加自定义字段
     * @var string[]
     */
    protected $appends = [
        'category_name',
        'preview'
    ];

    /**
     * 获取分类名称
     * @return string
     */
    public function getCategoryNameAttribute(): string
    {
        return EdithAttachmentCategory::where('id', $this->category_id)->value('title') ?: '默认分类';
    }

    /**
     * 获取预览路径
     * @return string|null
     */
    public function getPreviewAttribute(): ?string
    {
        return str_starts_with($this->url, 'http') ? $this->url : get_attachment($this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(EdithAttachmentChannel::class, 'channel_id')->select('id', 'access_id', 'access_secret', 'endpoint', 'bucket', 'domain', 'remark');
    }

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::deleted(function (EdithAttachment $attachment) {
            if ($attachment->driver == 'local') {
                Storage::disk('public')->delete($attachment->path);
            }
        });
    }
}
