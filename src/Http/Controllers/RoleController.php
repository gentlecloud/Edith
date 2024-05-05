<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\Select;

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

        $crud->operation()->rowOnlyEditDestroyAction('link', 'drawer', $this->controls());

        $crud->basicHeaderToolbar('drawer', "新增{$this->title}", $this->controls())->onlyBulkDeleteAction();
        return $crud;
    }

    public function controls(): array
    {

        return [
            (new FormItem('name', '权限名称'))->required(),

        ];
    }
}