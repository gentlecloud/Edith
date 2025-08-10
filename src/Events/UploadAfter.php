<?php
namespace Edith\Admin\Events;

use Illuminate\Http\Request;

class UploadAfter
{
    /**
     * 当前请求
     * @var Request
     */
    public Request $request;

    /**
     * 当前文件
     * @var array
     */
    public array $file;


    /**
     * 附件ID
     * @var int|null
     */
    public ?int $fileId = null;

    /**
     * 上传文件后事件，当前用于存储数据库，模块可自定事件处理
     * UploadAfter constructor.
     * @param Request $request
     * @param array $file
     */
    public function __construct(Request $request, array $file)
    {
        $this->request = $request;
        $this->file = $file;
        if (isset($file['id'])) {
            $this->fileId = $file['id'];
        }
    }
}
