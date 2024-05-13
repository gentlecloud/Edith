<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Divider;
use Gentle\Edith\Components\Amis\Form\FieldSet;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\InputPassword;
use Gentle\Edith\Components\Amis\Form\InputSwitch;
use Gentle\Edith\Components\Amis\Form\InputUploader;
use Gentle\Edith\Components\Pages\PageContainer;
use Gentle\Edith\Components\Pages\ProCard;
use Gentle\Edith\Exceptions\RendererException;
use Gentle\Edith\Models\EdithAdmin;
use Gentle\Edith\Services\AdminUserService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '基础配置';

    /**
     * @var string|null
     */
    protected ?string $serviceName = AdminUserService::class;

    /**
     * 系统配置
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException
     */
    public function index(Request $request)
    {
        $user = auth('manage')->user()->makeHidden(['google_secret', 'google_qrcode', 'lasted_at', 'created_at', 'updated_at'])->toArray();

        unset($user['log'], $user['platforms']);
        $form = (new Form)->title('资料编辑')->controls([
            (new FormItem('username', '用户名'))->required(),
            (new InputUploader('avatar', '头像'))->accept('image/*')->description('支持 jpg、jpeg、png 格式'),
            (new Divider),
            (new FieldSet('基本资料'))->body([
                (new FormItem('nickname', '昵称'))->placeholder('请输入昵称')->required(),
                (new FormItem('phone', '手机'))->placeholder('请输入手机'),
                (new FormItem('email', 'E-mail'))->placeholder('请输入电子邮箱'),
            ])->collapsable(),
            (new Divider),
            (new FieldSet('安全设置'))->body([
                (new InputSwitch('google_open', '谷歌验证'))->value(false)->onText('打开')->offText('关闭'),
                (new InputPassword('password', '新密码'))->placeholder('请输入新密码')
                    ->description('不修改请留空！'),
                (new InputPassword('confirm', '确认密码'))->placeholder('请再次输入新密码')
                    ->description('不修改请留空！'),
            ])->collapsable()
        ])->data($user);


        return engine((new PageContainer('账号设置'))->body((new ProCard)->body($form->api('post:' . url()->current()))));
    }

    /**
     * 保存账号设置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(['nickname', 'phone', 'email', 'password', 'confirm']);
        if ((!empty($data['password']) || !empty($data['confirm'])) && (empty($data['confirm']) || $data['password'] !== $data['confirm'])) {
            return error('两次输入的密码不一致！');
        }
        try {
            $this->service()->update($data, auth('manage')->id());
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('保存成功.');
    }
}
