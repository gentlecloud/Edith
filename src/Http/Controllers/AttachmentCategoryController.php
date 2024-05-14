<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Services\AttachmentCategoryService;
use Illuminate\Http\Request;

class AttachmentCategoryController extends Controller
{
    /**
     * 控制器标题
     * @var string|null
     */
    protected ?string $title = '附件分类';

    /**
     * 控制器模型
     * @var string|null
     */
    protected ?string $serviceName = AttachmentCategoryService::class;

    /**
     * @return array
     * @throws \Edith\Admin\Exceptions\ServiceException
     */
    public function datasource(): array
    {
        $list = parent::datasource();

        return array_merge([
            [
                'id' => 0,
                'title' => '默认目录'
            ]
        ], $list['items']);
    }
}