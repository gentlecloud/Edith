<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Columns\Column;
use Edith\Admin\Components\Columns\Item\SelectColumn;
use Edith\Admin\Components\Columns\Item\SwitchColumn;
use Edith\Admin\Components\Columns\Item\UploaderColumn;
use Edith\Admin\Components\Forms\SchemaForm;
use Edith\Admin\Components\Tables\Table;
use Edith\Admin\Events\AdminUserFormRenderBefore;
use Edith\Admin\Http\Actions\CreateSchemaDrawerAction;
use Edith\Admin\Http\Actions\DeleteAction;
use Edith\Admin\Http\Actions\EditSchemaDrawerAction;
use Edith\Admin\Models\EdithRole;
use Illuminate\Http\Request;

abstract class AdminController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '管理员';

    /**
     * 控制器服务层
     * @var string|null
     */
    protected ?string $daoName = "Edith\Admin\Dao\AdminUserDao";

    /**
     * 生成 Crud 列表页面
     * @param Table $table
     * @return Table
     * @throws \Exception
     */
    public function table(Table $table): Table
    {
        $table->column('id', 'ID')->sorter()->hideInSearch();
        $table->column('avatar.url', '头像')->valueType('avatar')->hideInSearch()->size('64');
        $table->column('username', '用户名')->sorter()->copyable();
        $table->column('nickname', '昵称')->editable()->hideInSearch();
        $table->column('phone', '手机号')->copyable();
        $table->column('lasted_at', '最后登录时间')->valueType('datetime')->sorter()->width(180)->hideInSearch();
        $table->column('lasted_at', '登录时间')->valueType('dateTimeRange')->hideInTable();
        $table->column('log.lasted_ip', '最后登录IP')->hideInSearch();
        $table->column('created_at', '创建时间')->valueType('datetime')->sorter()->hideInSearch()->width(180);
        $table->column('created_at', '创建时间')->valueType('dateRange')->hideInTable()->placeholder(['起始创建时间', '截止创建时间']);
        $table->column('status', '状态')
            ->valueType('select')
            ->valueEnum([1 => '启用', 0 => '禁用'])->editable([
                'type' => 'switch',
                'onText' => '启用',
                'offText' => '禁用'
            ])->quickEditEnabledOn('${id != 1}');

        $table->toolbar([
            new CreateSchemaDrawerAction('添加管理员', $this->fields())
        ]);

        $table->operation([
            (new EditSchemaDrawerAction('管理员', $this->fields()))->initApi('${id}'),
            (new DeleteAction('删除', '是否确认要删除${username}账号？'))->confirmType('pop')->visibleOn('${id != 1}')
        ]);

        $table->enableBatchStatus();
        $table->initQuickSaveItemApi();
        return $table;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function fields(): array
    {
        $roles = EdithRole::select('name as label', 'id as value')->get()->toArray();
        $columns =  [
            (new Column('id'))->hidden(),
            (new SelectColumn('role_ids', '角色'))
                ->options($roles)
                ->multiple()
                ->requiredOn('${id != ' . config('edith.auth.admin_id', 1) . '}')
                ->visibleOn('${id != 1}')
                ->when('id', config('edith.auth.admin_id', 1), '!='),
            (new UploaderColumn('avatar', '头像'))->button('上传头像'),
            (new Column('username', '账号'))->required('账号必须输入', [
                [
                    'unique' => 'edith_admins,username',
                    'update_unique' => 'edith_admins,username,{id}',
                    'message' => '账号已存在.'
                ],
                [
                    'min' => 5,
                    'message' => '账号最少5位数'
                ]
            ]),
            (new Column('nickname', '昵称'))->required(),
            (new Column('phone', '手机号'))->rules([
                [
                    'regex' => '/^1[3-9]\d{9}$/',
                    'message' => '手机号不正确'
                ]
            ]),
            (new Column('password', '密码'))
                ->valueType('password')
                ->extra('新增时留空默认为：a12345678，修改时留空则不修改。'),
            (new Column('email', '邮箱'))
        ];

        $event = new AdminUserFormRenderBefore();
        event($event);

        return array_merge($columns, $event->columns->toArray(), [
            (new SwitchColumn('status', '状态'))
                ->initialValue(1)
                ->disabledOn('${id == ' . config('edith.auth.admin_id', 1) . '}')
                ->checkedChildren('启用')
                ->unCheckedChildren('禁用')
                ->valueEnum([
                    1 => '启用',
                    0 => '禁用'
                ])
        ]);
    }

    /**
     * 表单页
     * @param $id
     * @return SchemaForm
     * @throws \Edith\Admin\Exceptions\DaoException|\Edith\Admin\Exceptions\RendererException
     */
    public function form($id = null)
    {
        $form = (new SchemaForm)
            ->initApi($id)
            ->title($id ? '编辑管理员' : '创建管理员')
            ->labelCol(['span' => 4])
            ->layoutType('DrawerForm');


        if (is_null($id)) {
            $google = new GoogleAuthenticator;
            $secret = $google->createSecret();
            $qrcode = $google->getQRCodeGoogleUrl($secret);
        }
        $form->column('username', '账号')->required();
        $form->uploader('avatar', '头像')->tooltip('只支持jpg、png格式文件')->button('上传头像')->aspect();
        $form->column('nickname', '昵称')->required();
        $form->column('phone', '手机号')->required();
        $form->column('password', '密码')->valueType('password')->extra('留空默认：123456');
        $form->column('email', '邮箱');
        $form->radio('sex', '性别')->valueEnum([1 => '男', 2 => '女'])->initialValue(1);
        $form->switch('google_open', '谷歌验证')->initialValue(false);
        $form->column('google_secret')->hidden()->when('google_open', true)->initialValue($secret ?? null);
        $form->image('google_qrcode', '谷歌二维码')
            ->readonly()
            ->ignore()
            ->width(150)
            ->when('google_open', true)
            ->initialValue($qrcode ?? null);
        $form->switch('status', '状态');

        return $form;
    }
}