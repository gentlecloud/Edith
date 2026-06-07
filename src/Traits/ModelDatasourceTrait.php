<?php
declare(strict_types=1);
namespace Edith\Admin\Traits;

use Edith\Admin\Dao\AttachmentDao;
use Edith\Admin\Exceptions\DaoException;

trait ModelDatasourceTrait
{
    /**
     * @var array
     */
    private array $attachmentValues = [];

    /**
     * 处理附件钩子
     * @param int|string $id
     * @return void
     * @throws DaoException
     */
    private function saveAttachment(int|string $id)
    {
        if (!empty($this->attachmentValues)) {
            AttachmentDao::useResource($this->attachmentValues, $id, $this->model::class);
        }
    }

    /**
     * 保存前置操作 保存钩子 包含新增和更新
     * @param array $data
     * @param $id
     * @return void
     */
    protected function saving(array &$data, $id = null)
    {

    }

    /**
     * 保存后置操作 保存钩子 包含新增和更新
     * @param array $data
     * @param null $model
     * @return void
     */
    protected function saved(array $data, $model = null)
    {

    }

    /**
     * 删除前置操作 删除钩子
     * @param $id
     * @return void
     */
    protected function deleting($id)
    {

    }

    /**
     * 删除后置操作 删除钩子
     * @param $id
     * @return void
     */
    protected function deleted($id)
    {

    }

    /**
     * 填充模型数据
     * @param array $data
     * @return array
     */
    private function fillData(array $data): array
    {
        if (count($this->fill) > 0) {
            $data = \request()->only($this->fill);
        }
        if (count($this->guard) > 0) {
            foreach ($this->guard as $item) {
                unset($data[$item]);
            }
        }
        if (!empty($this->attachmentFields)) {
            $attachments = [];
            foreach ($this->attachmentFields as $field) {
                if (isset($data[$field])) {
                    $value = is_string($data[$field]) && str_contains($data[$field], '[') ? json_decode($data[$field], true) : $data[$field];
                    if (is_numeric($value)) {
                        $data[$field] = intval($value);
                        $attachments[] = $value;
                    } else if (isset($value['id'])) {
                        $data[$field] = $value['id'];
                        $attachments[] = $value['id'];
                    } else if (is_array($value)) {
                        $data[$field] = array_column($data[$field], 'id');
                        $attachments = array_merge($attachments, $data[$field]);
                    }
                }
            }
            $this->attachmentValues = $attachments;
        }
        return $data;
    }
}