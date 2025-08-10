<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Columns\Item\TreeColumn;
use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Http\Actions\CreateSchemaDrawerAction;
use Edith\Admin\Http\Actions\EditSchemaDrawerAction;
use Edith\Admin\Models\EdithMenu;
use Edith\Admin\Models\EdithPermission;

class RoleController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '角色';

    /**
     * @var string|null
     */
    protected ?string $daoName = "Edith\Admin\Dao\RoleDao";

    /**
     * 生成 Crud 列表页面
     * @param Table $table
     * @return Table
     * @throws \Exception
     */
    public function table(Table $table): Table
    {
        $table->column('id', 'ID')->hideInSearch()->width(90);
        $table->column('name', '角色名称')->editable();
        $table->column('guard_name', '权限组');
        $table->column('created_at', '创建时间')->valueType('datetime')->hideInSearch()->width(180);
        $table->column('created_at', '创建时间')->valueType('dateRange')->hideInTable();
        $table->column('updated_at', '更新时间')->valueType('datetime')->hideInSearch()->width(180);

        $table->operation([
            (new EditSchemaDrawerAction('角色', $this->fields()))->initApi('${id}'),
        ])->rowOnlyDestroyAction()->width(100);
        $table->toolbar([
            new CreateSchemaDrawerAction('添加角色', $this->fields())
        ]);
        return $table;
    }

    /**
     * @return array
     * @throws \Edith\Admin\Exceptions\RendererException
     */
    public function fields(): array
    {
        $menus = EdithMenu::where('parent_id', 0)->whereIn('guard_name', ['basic', 'admin'])->select('id', 'name')->get()->toArray();
        foreach ($menus as $k => $v) {
            $children = EdithMenu::where('parent_id', $v['id'])->whereIn('guard_name', ['basic', 'admin'])->select('id', 'name')->get()->toArray();
            foreach ($children as $key => $value) {
                $permission = EdithPermission::where('menu_id', $value['id'])->select('id', 'name')->get()->toArray();
                foreach ($permission as $kk => $vv) {
                    $permission[$kk]['id'] = "permission{{$vv['id']}}";
                }
                $children[$key]['id'] = strval($value['id']);
                $children[$key]['children'] = $permission;
            }
            $parentPermission = EdithPermission::where('menu_id', $v['id'])->select('id', 'name')->get()->toArray();
            foreach ($parentPermission as $key => $value) {
                $parentPermission[$key]['id'] = "permission{{$value['id']}}";
            }
            $menus[$k]['id'] = strval($v['id']);
            $menus[$k]['children'] = array_merge($children, $parentPermission);
        }
        return [
            (new Column('id', 'ID'))->hidden(),
            (new Column('name', '角色名称'))->required(),
            (new Column('guard_name', '权限组'))->required(),
            (new TreeColumn('permission_ids', '权限'))
                ->required()
                ->fieldNames(['key' => 'id', 'title' => 'name'])
                ->valueEnum($menus),
        ];
    }
}