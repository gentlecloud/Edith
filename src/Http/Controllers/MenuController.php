<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Columns\GroupColumn;
use Edith\Admin\Components\Columns\Item\DigitColumn;
use Edith\Admin\Components\Columns\Item\HiddenColumn;
use Edith\Admin\Components\Columns\Item\IconSelect;
use Edith\Admin\Components\Columns\Item\RadioButtonColumn;
use Edith\Admin\Components\Columns\Item\SwitchColumn;
use Edith\Admin\Components\Columns\Item\TreeSelectColumn;
use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Http\Actions\CreateSchemaDrawerAction;

class MenuController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '菜单';

    /**
     * @var string|null
     */
    protected ?string $daoName = "Edith\Admin\Dao\MenuDao";

    /**
     * 生成 Crud 列表页面
     * @return Table
     * @throws \Exception
     */
    public function table(Table $table)
    {
        $table->column('id', 'ID')->width(100)->hideInSearch();
        $table->column('icon', '菜单图标')->hideInSearch();
        $table->column('name', '菜单名称');
        $table->column('path', '菜单路由')->copyable();
        $table->column('type', '菜单类型')->valueEnum([
            'engine' => '翼搭引擎',
            'default' => '路由',
            '_blank' => '外链',
            'iframe' => 'iframe'
        ]);
        $table->column('sort', '排序')->editable([
            'type' => 'input-number'
        ])->hideInSearch();
        $table->column('status', '状态')->editable([
            'type' => 'switch',
            'onText' => '启用',
            'offText' => '禁用'
        ])->valueEnum([
            1 => '启用',
            0 => '禁用'
        ])->valueType('select');
        $table->column('created_at', '创建时间')->hideInSearch();
        $table->column('updated_at', '更新时间')->hideInSearch();

        $table->operation()->rowOnlyEditDestroyAction($this->fields(), $this->title);
        $table->toolbar([
            new CreateSchemaDrawerAction('添加' . $this->title, $this->fields())
        ]);

        $table->enableBatchStatus();

        return $table->pagination(false);
    }

    /**
     * 表单列
     * @return array
     * @throws \Edith\Admin\Exceptions\DaoException
     */
    public function fields(): array
    {
        $menus = list_to_tree($this->dao()->getModel()->select('id as value', 'parent_id', 'name as label', 'icon')->get(), 'value', 'parent_id', 'children');
        return [
            (new HiddenColumn('id')),
            (new GroupColumn())->columns([
                (new IconSelect('icon', '图标'))->width(180)->showSearch(),
                (new Column('name', '菜单名称'))->required()->width('md'),
            ]),
            (new TreeSelectColumn('parent_id', '上级菜单'))
                ->defaultValue(0)
                ->options(array_merge([['value' => 0, 'label' => '一级菜单']], $menus))
                ->treeDefaultExpandAll(),
            (new GroupColumn())->columns([
                (new RadioButtonColumn('guard_name', '权限组'))
                    ->defaultValue('basic')
                    ->valueEnum([
                        'basic' => '基础',
                        'admin' => '主站',
                        'platform' => 'SAAS'
                    ])
                    ->tooltip('基础则主应用及SAAS共用，主站为翼搭主后台。SAAS仅在租户后台显示')
                    ->width('md'),
                (new RadioButtonColumn('type', '类型'))
                    ->tooltip('插件请使用翼搭引擎生辰JsonSchema，外链：会打开标签页跳转;iframe：嵌套于翼搭Layout内。')
                    ->extra('路由仅支持前端内置路由！')
                    ->valueEnum([
                        'engine' => '翼搭引擎',
                        'default' => '路由',
                        '_blank' => '外链',
                        'iframe' => 'iframe'
                    ])
                    ->defaultValue('engine')
                    ->width('md'),
            ]),
            (new Column('path', '路由'))->required([
                [
                    'unique' => 'edith_menus,path',
                    'update_unique' => 'edith_menus,path,{id}',
                    'message' => '路由已存在'
                ]
            ]),
            (new Column('component', '组件'))
                ->tooltip('仅支持翼搭前端集成的组件，若非必要或非自定义前端页面则无需更改！')
                ->extra('默认为：Engine，翼搭引擎组件，支持各类JsonSchema')
                ->defaultValue('Engine'),
            (new GroupColumn())->columns([
                (new DigitColumn('sort', '排序'))->width('md'),
                (new SwitchColumn('status', '状态'))->checkedChildren('启用')->unCheckedChildren('禁用')->valueEnum([
                    1 => '启用',
                    0 => '禁用'
                ])->defaultChecked(1)->width('xs')
            ])
        ];
    }
}