<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\Group;
use Gentle\Edith\Components\Amis\Form\Hidden;
use Gentle\Edith\Components\Amis\Form\InputNumber;
use Gentle\Edith\Components\Amis\Form\InputSwitch;
use Gentle\Edith\Components\Amis\Form\InputText;
use Gentle\Edith\Components\Amis\Form\ListSelect;
use Gentle\Edith\Components\Amis\Form\TreeSelect;

class MenuController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '菜单';

    /**
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\MenuService";

    /**
     * 生成 Crud 列表页面
     * @param Crud $crud
     * @return Crud
     * @throws \Exception
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('id', '序号')->width(60);
        $crud->column('icon', '菜单图标');
        $crud->column('name', '菜单名称');
        $crud->column('path', '菜单路由')->copyable();
        $crud->column('sort', '排序')->quickEdit(['saveImmediately' => true]);
        $crud->column('status', '状态')->quickEdit([
            "mode" => "inline",
            'type' => 'switch',
            'onText' => '启用',
            'offText' => '禁用',
            'saveImmediately' => true
        ]);
        $crud->column('created_at', '创建时间');
        $crud->column('updated_at', '更新时间');

        if (env('APP_DEBUG', false)) {
            $crud->operation()->rowOnlyEditDestroyAction($this->controls());
            $crud->onlyBulkStatusDeleteAction()->basicHeaderToolbar($this->controls(), 'modal', "创建{$this->title}");
        } else {
            $crud->onlyBulkStatusAction();
        }

        return $crud->footerToolbar(['statistics'])->draggable()->loadDataOnce()->quickSaveApi()->quickSaveItemApi();
    }

    /**
     * 表单列
     * @return array
     * @throws \Gentle\Edith\Exceptions\ServiceException
     */
    public function controls(): array
    {
        $menus = list_to_tree($this->service()->getModel()->select('id', 'parent_id', 'name as label', 'icon')->get(), 'id', 'parent_id', 'children');
        return [
            (new Group)->body([
                (new FormItem('icon', '菜单图标')),
                (new InputText('name', '菜单名称'))->required()
            ]),
            (new TreeSelect('parent_id', '上级菜单'))->options(array_merge([['id' => 0, 'label' => '一级菜单']], $menus))->showIcon(false)->valueField('id')->required(),
            (new InputText('path', '链接路径'))->description('一级菜单以 "/" 开头，子菜单不以 "/"开头')->required(),
            (new ListSelect('target', '类型'))->options([
                'default' => '路由',
                'engine' => '翼搭引擎',
                '_blank' => '外链'
            ])->value('default'),
            (new Group)->body([
                (new InputNumber('sort', '排序'))->description('由小到大排列')->placeholder('请输入排序，由小到大排列'),
                (new InputSwitch('status', '状态'))->onText('启用')->offText('禁用')->value(1)
            ])
        ];
    }
}