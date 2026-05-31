<?php
namespace Edith\Admin\Listeners;

use Edith\Admin\Events;
use Edith\Admin\Models\EdithAttachment;

class AttachmentUploadAfter
{
    /**
     * 上传附件后事件处理 当前仅存储数据库
     * @param Events\AttachmentUploadAfter $event
     */
    public function handle(Events\AttachmentUploadAfter $event) {
        if (!isset($event->file['id'])) {
            $data = $event->file;
            if (app('edith.auth')->id()) {
                $data['obj_id'] = app('edith.auth')->id();
                $data['obj_type'] = 'ADMIN';
            } else {
                $data['obj_id'] = app('edith.auth')->platformId();
                $data['obj_type'] = 'PLATFORM';
            }
            $data['platform_id'] = app('edith.auth')->platformId();
            $create = EdithAttachment::create($data);
            $event->fileId = $create->id;
        }
    }
}
