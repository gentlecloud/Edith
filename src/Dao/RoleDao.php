<?php
namespace Edith\Admin\Dao;

use Edith\Admin\Models\EdithMenu;
use Edith\Admin\Models\EdithPermission;
use Edith\Admin\Models\EdithRole;
use Edith\Admin\Models\EdithRoleMenu;
use Edith\Admin\Models\EdithRolePermission;

class RoleDao extends ModelDao
{
    /**
     * 定义模型名称
     * @var string|null
     */
    protected ?string $modelName = EdithRole::class;

    protected array $guard = ['permission_ids', 'permissions'];

    /**
     * @param $id
     * @return mixed
     * @throws \Edith\Admin\Exceptions\DaoException
     */
    public function get($id = null)
    {
        $info = parent::get($id);
        $checkedIds = [];
        $menus = $info->menus()->pluck('menu_id')->toArray();
        foreach ($menus as $menuId) {
            $checkedIds[] = strval($menuId);
        }
        $permissions = $info->permissions()->pluck('permission_id')->toArray();
        foreach ($permissions as $permission) {
            $checkedIds[] = "permission{{$permission}}";
        }
        $info['permission_ids'] = $checkedIds;
        return $info;
    }

    /**
     * @param $data
     * @param $id
     * @return void
     */
    protected function saved($data, $id = null)
    {
        $permissions = $data['permission_ids'];
        EdithRolePermission::where('role_id', $id)->delete();
        EdithRoleMenu::where('role_id', $id)->delete();
        $menuIds = [];
        foreach ($permissions as $permissionId) {
            if (str_contains($permissionId, 'permission') && preg_match('/permission\{(\d+)\}/', $permissionId, $matches)) {
                EdithRolePermission::updateOrCreate([
                    'role_id' => $id,
                    'permission_id' => $matches[1]
                ]);
            } else if (!in_array($permissionId, $menuIds)) {
                $menuIds[] = $permissionId;
                EdithRoleMenu::create([
                    'role_id' => $id,
                    'menu_id' => $permissionId
                ]);
            }
        }
    }
}