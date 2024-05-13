<?php
namespace Gentle\Edith\Services;

use Gentle\Edith\Models\EdithAttachment;

class AttachmentCategoryService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Gentle\Edith\Models\EdithAttachmentCategory';

    /**
     * @param $id
     * @return void
     * @throws \Gentle\Edith\Exceptions\ServiceException
     */
    protected function deleting($id)
    {
        if (EdithAttachment::where('category_id', $id)->exists())
            throw new ServiceException('当前分类下存在附件，无法删除.');
    }
}