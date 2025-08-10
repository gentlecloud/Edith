<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Dao\AttachmentCategoryDao;
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
    protected ?string $daoName = AttachmentCategoryDao::class;

    /**
     * @return array
     * @throws \Edith\Admin\Exceptions\DaoException
     */
    public function datasource(): array
    {
        $list = parent::datasource();

        $list['items'] = array_merge([
            [
                'id' => 0,
                'title' => '默认目录'
            ]
        ], $list['items']);
        return $list;
    }
}