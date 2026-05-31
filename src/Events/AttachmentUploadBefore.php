<?php
namespace Edith\Admin\Events;

use Illuminate\Http\Request;

/**
 * Class AttachmentUploadBefore
 * 上传文件前触发事件
 * @package Edith\Admin\Events
 */
class AttachmentUploadBefore
{
    /**
     * Request 实例
     * @var \Illuminate\Http\Request
     */
    public Request $request;

    /**
     * 当前平台ID 0为控制台
     * @var int
     */
    public int $platform_id = 0;

    /**
     * 上传文件信息
     * @var array|null
     */
    public ?array $file = null;

    /**
     * 构造方法
     * AttachmentUploadBefore constructor.
     * @param Request $request
     * @param int $platform_id
     */
    public function __construct(Request $request, int $platform_id = 0)
    {
        $this->request = $request;
        $this->platform_id = $platform_id;
    }
}
