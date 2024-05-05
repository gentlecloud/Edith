<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\Button;
use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\InputDate;
use Gentle\Edith\Components\Amis\Form\InputDatetimeRange;
use Gentle\Edith\Components\Forms\SchemaForm;
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
        $crud->column('nickname', '昵称');
        $crud->column('phone', '手机号')->copyable();
        $crud->column('email', '邮箱')->copyable();
        $crud->column('sex', '性别')->map(['1' => '男', '2' => '女', '0' => '未知']);
        $crud->column('lasted_at', '最后登录时间')->type('datetime');
        $crud->column('log.lasted_ip', '最后登录IP');
        $crud->column('status', '状态')->map(['1' => '正常', '0' => '禁用'])->quickEdit([
            "mode" => "inline",
            'type' => 'switch',
            'onText' => '启用',
            'offText' => '禁用',
            'saveImmediately' => true
        ])->quickEditEnabledOn('${id !== 1}');

        $crud->operation()->rowOnlyEditAction()->button('删除', function(Button $button) {
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
        $crud->onlyBulkDeleteAction()->basicHeaderToolbar($this->form())->quickSaveItemApi();
        return $crud;
    }

    /**
     * 表单页
     * @param $id
     * @return SchemaForm
     * @throws \Gentle\Edith\Exceptions\ServiceException
     */
    public function form($id = null)
    {
        $form = (new SchemaForm)->layoutType('DrawerForm')->labelCol(['span' => 4]);
//        $form->onAction()->api([
//            'method' => 'PUT',
//            'url' => url('api/auth/admin/2')
//        ]);

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