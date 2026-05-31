<?php
namespace Edith\Admin\Events;

use Illuminate\Support\Collection;

/**
 * Class AttachmentDestroyBefore
 * 附件删除前事件
 * @package Edith\Admin\Events
 */
class AttachmentDestroyBefore
{
    /**
     * 附件
     */
    public Collection $attachments;

    /**
     * 构造方法
     * AuthLoginBefore constructor.
     * @param Collection $attachments
     */
    public function __construct(Collection $attachments)
    {
        $this->attachments = $attachments;
    }
}
