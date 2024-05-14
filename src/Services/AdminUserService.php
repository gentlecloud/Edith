<?php
namespace Edith\Admin\Services;

use Edith\Admin\Exceptions\ServiceException;
use Edith\Admin\Models\EdithRole;
use Edith\Admin\Models\EdithRoleUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AdminUserService extends ModelService
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithAdmin';

    /**
     * @var array|string[]
     */
    protected array $guard = ['log', 'google_qrcode', 'confirm', 'role_ids'];

    /**
     * @var string 
     */
    protected string $orderBy = 'asc';

    /**
     * @return Builder
     * @throws ServiceException
     */
    public function query(): Builder
    {
        return parent::query()->when(request()->input('lasted_at'), function ($query) {
            $query->whereBetween('lasted_at', $this->handleSearchTime('lasted_at'));
        });
    }

    /**
     * @return array
     * @throws ServiceException
     */
    public function builder(): array
    {
        $query = $this->query();

        $paginate = $query->paginate(\request()->input('perPage', 20));
        return ['items' => $paginate->makeVisible(['google_secret'])->toArray(), 'total' => $paginate->total()];
    }

    /**
     * @param $data
     * @param $id
     * @return void
     */
    protected function saving(&$data, $id = null)
    {
        if (empty($data['password'])) {
            if (empty($id)) {
                $data['password'] = 123456;
            } else {
                unset($data['password']);
            }
        }
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     * @throws ServiceException
     */
    protected function saved($data, $id = null)
    {
        if (isset($data['role_ids'])) {
            EdithRoleUser::where('user_id', $id)->delete();
            $ids = is_array($data['role_ids']) ? $data['role_ids'] : explode(',', $data['role_ids']);
            foreach ($ids as $roleId) {
                if (EdithRole::where('id', $roleId)->doesntExist()) {
                    continue;
                }
                EdithRoleUser::create([
                    'role_id' => $roleId,
                    'user_id' => $id
                ]);
            }
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws ServiceException
     */
    public function get($id = null)
    {
        $info = $this->getModel()->withOut('log')->findOrFail($id ?: \request()->input('id'))->append('google_qrcode')->toArray();
        $info['role_ids'] = EdithRoleUser::where('user_id', $id)->pluck('role_id');
        return $info;
    }

    /**
     * @param $id
     * @return mixed
     * @throws ServiceException
     */
    public function destroy($id)
    {
        if (is_array($id) && in_array(1, $id) || $id == 1) {
            throw new \Exception("超级管理员不允许删除！");
        }
        return parent::destroy($id);
    }
}