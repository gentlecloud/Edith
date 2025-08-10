<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Models\EdithAttachment;

class AttachmentCategoryDao extends ModelDao
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithAttachmentCategory';

    /**
     * @param $id
     * @return void
     * @throws \Edith\Admin\Exceptions\DaoException
     */
    protected function deleting($id)
    {
        if (EdithAttachment::where('category_id', $id)->exists())
            throw new ServiceException('当前分类下存在附件，无法删除.');
    }
}