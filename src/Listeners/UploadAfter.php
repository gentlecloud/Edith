<?php
namespace Gentle\Edith\Listeners;

use Gentle\Edith\Events;
use Gentle\Edith\Models\EdithAttachment;

class UploadAfter
{
    /**
     * 上传附件后事件处理 当前仅存储数据库
     * @param Events\UploadAfter $event
     */
    public function handle(Events\UploadAfter $event) {
        if (!isset($event->file['id'])) {
            $data = $event->file;
            if (!$data['obj_id']) {
                $data['obj_id'] = app('edith.auth')->id();
                $data['obj_type'] = 'ADMIN';
            } else {
                $data['obj_type'] = 'PLATFORM';
            }
            $create = EdithAttachment::create($data);
            $event->fileId = $create->id;
        }
    }
}
