<?php
namespace Gentle\Edith\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AdminUserService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Gentle\Edith\Models\EdithAdmin';

    /**
     * @var array|string[]
     */
    protected array $guard = ['log', 'google_qrcode'];

    /**
     * @return Builder
     * @throws \Exception
     */
    public function query(): Builder
    {
        if (!$this->model) {
            throw new \Exception('The current service layer is not configured with a model.');
        }
        return $this->model::query()->where('type', 'admin');
    }

    /**
     * @param int|null $id
     * @return mixed
     * @throws \Exception
     */
    public function get(?int $id = null)
    {
        return $this->query()->withOut('log')->findOrFail($id ?: \request()->input('id'))->append('google_qrcode')->toArray();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($id == 1) {
            throw new \Exception("超级管理员不允许删除！");
        }
        return parent::destroy($id);
    }
}