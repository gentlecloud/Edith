<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\InputTree;
use Gentle\Edith\Components\Amis\Form\Select;
use Gentle\Edith\Models\EdithMenu;
use Gentle\Edith\Models\EdithPermission;

class RoleController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '角色';

    /**
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\RoleService";

    /**
     * 生成 Crud 列表页面
     * @param Crud $crud
     * @return Crud
     * @throws \Exception
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('id', '序号')->width(60);
        $crud->column('name', '权限名称');
        $crud->column('guard_name', '权限组');
        $crud->column('created_at', '创建时间');
        $crud->column('updated_at', '更新时间');

        $crud->operation()->rowOnlyEditDestroyAction($crud->makeForm($this->controls(), 'api/auth/role/${id}?_action=datasource'), 'drawer');

        $crud->basicHeaderToolbar($this->controls(), 'drawer', "新增{$this->title}")->onlyBulkDeleteAction();
        return $crud;
    }

    public function controls(): array
    {
        $menus = EdithMenu::where('parent_id', 0)->select('id', 'name')->get()->toArray();
        foreach ($menus as $k => $v) {
            $children = EdithMenu::where('parent_id', $v['id'])->select('id', 'name')->get()->toArray();
            foreach ($children as $key => $value) {
                $permission = EdithPermission::where('menu_id', $value['id'])->select('id', 'name', 'menu_id')->get()->toArray();
//                foreach ($permission as $kk => $vv) {
//                    $permission[$kk]['id'] = $value['id'] . '-' . $vv['id'];
//                }
                $children[$key]['id'] = "{$v['id']}-{$value['id']}";
                $children[$key]['children'] = $permission;
            }
            $menus[$k]['id'] = "0-{$v['id']}";
            $menus[$k]['children'] = $children;
        }
        return [
            (new FormItem('name', '权限名称'))->required(),
            (new InputTree('permission_ids', '权限'))->searchable()
                ->multiple()
                ->cascade()
                ->valueField('id')
                ->labelField('name')
                ->required()
                ->options($menus),
        ];
    }
}