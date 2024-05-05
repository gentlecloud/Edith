<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Divider;
use Gentle\Edith\Components\Amis\Form\FieldSet;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\InputPassword;
use Gentle\Edith\Components\Amis\Form\InputSwitch;
use Gentle\Edith\Components\Pages\PageContainer;
use Gentle\Edith\Components\Pages\ProCard;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '基础配置';

    /**
     * 控制器服务层
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\ConfigService";

    /**
     * 系统配置
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException
     */
    public function index(Request $request)
    {
        $user = auth('manage')->user()->makeHidden(['google_secret', 'google_qrcode'])->toArray();
        $form = (new Form)->title('资料编辑')->controls([
            (new FormItem('username', '用户名'))->disabled(),
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
        $data = $request->only(['id', 'nickname', 'phone', 'email', 'password', 'confirm']);

        return success('保存成功.');
    }
}
