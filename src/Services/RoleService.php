<?php
namespace Edith\Admin\Services;

use Edith\Admin\Models\EdithMenu;
use Edith\Admin\Models\EdithPermission;
use Edith\Admin\Models\EdithRole;
use Edith\Admin\Models\EdithRoleMenu;
use Edith\Admin\Models\EdithRolePermission;

class RoleService extends ModelService
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
     * @throws \Edith\Admin\Exceptions\ServiceException
     */
    public function get($id = null)
    {
        $info = parent::get($id);
        $info['permission_ids'] = $info->permissions()->pluck('permission_id')->toArray();
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
            if (!str_contains($permissionId, '-') && ($permission = EdithPermission::find($permissionId))) {
                EdithRolePermission::updateOrCreate([
                    'role_id' => $id,
                    'permission_id' => $permissionId
                ]);
                if (!in_array($permission['menu_id'], $menuIds)) {
                    $menuIds[] = $permission['menu_id'];
                    EdithRoleMenu::create([
                        'role_id' => $id,
                        'menu_id' => $permission['menu_id']
                    ]);
                    $menu = EdithMenu::select('id', 'parent_id')->find($permission['menu_id']);
                    while ($menu && $menu['parent_id']) {
                        if (!in_array($menu['parent_id'], $menuIds)) {
                            EdithRoleMenu::create([
                                'role_id' => $id,
                                'menu_id' => $menu['parent_id']
                            ]);
                            $menuIds[] = $menu['parent_id'];
                        }
                        $menu = EdithMenu::select('id', 'parent_id')->find($menu['parent_id']);
                    }
                }
            }
        }
    }
}