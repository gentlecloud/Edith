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
        'url',
        'preview'
    ];

    /**
     * 获取分类名称
     * @return string
     */
    public function getCategoryNameAttribute(): string
    {
        return EdithAttachmentCategory::where('id',$this->category_id)->value('title') ?: '默认分类';
    }

    /**
     * 获取附件外链
     * @return string|null
     */
    public function getUrlAttribute(): ?string
    {
        return (isset($this->driver) && $this->driver != 'local' || substr($this->path, 0, 4) == 'http') ? $this->path : asset(Storage::url($this->path));
    }

    /**
     * 获取预览路径
     * @return string|null
     */
    public function getPreviewAttribute(): ?string
    {
        return substr($this->path, 0, 4) == 'http' ? $this->path : get_attachment($this->id);
    }

    protected static function booted(): void
    {
        static::deleted(function (EdithAttachment $attachment) {
            if ($attachment->driver == 'local') {
                Storage::delete($attachment->path);
            }
        });
    }
}
