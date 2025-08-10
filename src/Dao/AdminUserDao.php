<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Models\EdithRole;
use Edith\Admin\Models\EdithRoleUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AdminUserDao extends ModelDao
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = 'Edith\Admin\Models\EdithAdmin';

    /**
     * @var array|string[]
     */
    protected array $guard = ['log', 'google_qrcode', 'old_password', 'password_confirmation', 'role_ids'];

    /**
     * @var string 
     */
    protected string $orderBy = 'asc';

    /**
     * @return Builder
     * @throws DaoException
     */
    public function query(): Builder
    {
        return parent::query()->when(\request()->input('username'), function ($query, $value) {
            $query->where('username', 'like', "%{$value}%");
        })->when(request()->input('lasted_at'), function ($query) {
            $query->whereBetween('lasted_at', $this->handleSearchTime('lasted_at'));
        });
    }

    /**
     * @return array
     * @throws DaoException
     */
    public function builder(): array
    {
        $query = $this->query();
        $paginate = $query->paginate(\request()->input('pageSize', 50), ['*'], 'page', \request()->input('current', 1));
        $items = $paginate->makeVisible(['google_secret']);
        foreach ($items as &$item) {
            $item['roles'] = $item->roles()->pluck('name')->toArray();
        }
        return ['items' => $items, 'total' => $paginate->total(), 'page' => $paginate->lastPage(), 'current' => $paginate->currentPage()];
    }

    /**
     * @param $data
     * @param null $id
     * @return void
     * @throws DaoException
     */
    protected function saving(&$data, $id = null)
    {
        if (!empty($id) && isset($data['status']) && (!$data['status'] || $data['status'] == '0') && $id == strval(config('edith.auth.admin_id'))) {
            throw new DaoException('超级管理员无法禁用.');
        }
        if (empty($data['password'])) {
            if (empty($id)) {
                $data['password'] = 'a12345678';
            } else {
                unset($data['password']);
            }
        }
    }

    /**
     * @param $data
     * @param $id
     * @return void
     * @throws DaoException
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
     * @throws DaoException
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
     * @throws DaoException
     */
    public function destroy($id)
    {
        if (is_array($id) && in_array(strval(config('edith.auth.admin_id')), $id) || $id == strval(config('edith.auth.admin_id'))) {
            throw new \Exception("超级管理员不允许删除！");
        }
        return parent::destroy($id);
    }
}