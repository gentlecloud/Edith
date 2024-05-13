<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\Button;
use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\Hidden;
use Gentle\Edith\Components\Amis\Form\InputDate;
use Gentle\Edith\Components\Amis\Form\InputDatetimeRange;
use Gentle\Edith\Components\Amis\Form\InputImage;
use Gentle\Edith\Components\Amis\Form\InputPassword;
use Gentle\Edith\Components\Amis\Form\InputStatic;
use Gentle\Edith\Components\Amis\Form\InputSwitch;
use Gentle\Edith\Components\Amis\Form\InputUploader;
use Gentle\Edith\Components\Amis\Form\Select;
use Gentle\Edith\Components\Amis\Show\Qrcode;
use Gentle\Edith\Components\Forms\SchemaForm;
use Gentle\Edith\Models\EdithRole;
use Gentle\Edith\Support\GoogleAuthenticator;

class AdminController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '管理员';

    /**
     * 控制器服务层
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\AdminUserService";

    /**
     * 生成 Crud 列表页面
     * @param Crud $crud
     * @return Crud
     * @throws \Exception
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('id', 'ID')->sortable();
        $crud->column('avatar', '头像')->type('avatar')->src('${avatar}');
        $crud->column('username', '用户名')->sortable()->copyable();
        $crud->column('nickname', '昵称')->quickEdit();
        $crud->column('phone', '手机号')->copyable();
        $crud->column('lasted_at', '最后登录时间')->type('datetime');
        $crud->column('log.lasted_ip', '最后登录IP');
        $crud->column('status', '状态')->map(['1' => '正常', '0' => '禁用'])->quickEdit([
            "mode" => "inline",
            'type' => 'switch',
            'onText' => '启用',
            'offText' => '禁用',
            'saveImmediately' => true
        ])->quickEditEnabledOn('${id !== 1}');

        $crud->operation()->rowOnlyEditAction($crud->makeForm($this->controls(), 'api/auth/admin/${id}?_action=datasource'), 'drawer')->button('删除', function(Button $button) {
            $button->api('delete:' . url()->current() . '/${id}')
                ->actionType('ajax')
                ->level('link')
                ->confirmText('请确认是否要删除所选项？')
                ->style(['color' => '#FF5722'])
                ->visibleOn('${id !== 1}');
        });

        $crud->filter([
            (new FormItem('keyword', '关键词'))->size('md')->placeholder('请输入账号|昵称'),
            new InputDatetimeRange('lasted_at', '登录时间'),
            new InputDatetimeRange('created_at', '创建时间')
        ]);
        $crud->onlyBulkDeleteAction()->basicHeaderToolbar($this->controls(), 'drawer', '创建管理员')->quickSaveItemApi()->itemCheckableOn('${id !== 1}');
        return $crud;
    }

    public function controls()
    {
        $google = new GoogleAuthenticator;
        $secret = $google->createSecret();
        $qrcode = $google->getQRCodeGoogleUrl('${google_secret}');

        $roles = EdithRole::select('id as value', 'name as label')->get()->toArray();
        return [
            (new Select('role_ids', '角色'))->options($roles)->multiple()->searchable()->clearable()->visibleOn('${id !== 1}'),
            (new FormItem('username', '账号'))->required(),
            (new InputUploader('avatar', '头像'))->description('只支持jpg、png格式文件'),
            (new FormItem('nickname', '昵称'))->required(),
            (new FormItem('phone', '手机号'))->required(),
            (new InputPassword('password', '密码'))->description('留空默认为：123456'),
            (new FormItem('email', '邮箱')),
            (new InputSwitch('google_open', '谷歌验证'))->onText('启用')->offText('禁用')->value(0)->trueValue(1)->falseValue(0),
            (new Hidden('google_secret'))->value($secret),
            (new InputStatic('google_qrcode'))->value($qrcode)->type('static-image')->visibleOn('${google_open === 1}'),
            (new InputSwitch('status', '状态'))->onText('正常')->offText('禁用')->value(1)->trueValue(1)->falseValue(0)->visibleOn('${id !== 1}')
        ];
    }

    /**
     * 表单页
     * @param $id
     * @return SchemaForm
     * @throws \Gentle\Edith\Exceptions\ServiceException
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
        $form->column('google_secret')->hidden()->dependencies('google_open', true)->initialValue($secret ?? null);
        $form->image('google_qrcode', '谷歌二维码')
            ->readonly()
            ->ignore()
            ->width(150)
            ->dependencies('google_open', true)
            ->initialValue($qrcode ?? null);
        $form->switch('status', '状态');

        return $form;
    }
}