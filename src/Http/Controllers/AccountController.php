<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Fields\Item\Uploader;
use Edith\Admin\Components\Forms\ProForm;
use Edith\Admin\Components\Layouts\Menu;
use Edith\Admin\Components\Layouts\MenuItem;
use Edith\Admin\Components\Pages\PageContainer;
use Edith\Admin\Components\Pages\ProCard;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Dao\AdminUserDao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '基础配置';

    /**
     * @var string|null
     */
    protected ?string $daoName = AdminUserDao::class;

    /**
     * 系统配置
     * @return \Illuminate\Http\JsonResponse
     * @throws RendererException
     */
    public function index(Request $request)
    {
        $user = auth('manage')->user()->makeHidden(['google_secret', 'google_qrcode', 'lasted_at', 'created_at', 'updated_at', 'log', 'platforms'])->toArray();

        $menu = (new Menu())
            ->items([
                (new MenuItem('账号设置', 'account')),
                (new MenuItem('安全设置', 'security')),
            ])
            ->style(['minHeight' => 600, 'borderInlineEnd' => 'none'])
            ->mode('inline')
            ->selectedKeys(['account']);

        $form = (new ProForm())
            ->scopeName('account_form')
            ->initialValues($user)
            ->columns([
                (new ProCard())
                    ->title('账号设置')
                    ->body($this->fields())
                    ->visibleOn('includes(menu_select_key, \'account\')'),
                (new ProCard())
                    ->title('安全设置')
                    ->body([
                        (new Field('old_password', '旧密码'))->component('password')->required(),
                        (new Field('password', '新密码'))->component('password')->required(),
                        (new Field('password_confirmation', '确认密码'))->component('password')->required(),
                    ])
                    ->visibleOn('includes(menu_select_key, \'security\')'),
            ]);

        $card = (new ProCard())->split('vertical')->body([
            (new ProCard())->colSpan('20%')->body($menu),
            (new ProCard())->body($form),
        ]);

        return engine((new PageContainer('账号设置'))->subTitle('账号设置/安全设置需分别提交保存！')->body($card));
    }

    /**
     * @return array
     * @throws RendererException
     */
    public function fields(): array
    {
        return [
            (new Field('username', '用户名'))->disabled()->required()->tooltip('暂不支持修改，请联系管理员.'),
            (new Field('nickname', '昵称'))->required(),
            (new Uploader('avatar', '头像'))->button('上传头像'),
            (new Field('phone', '手机号'))->required('手机号必须输入', [
                [
                    'regex' => '/^1[3-9]\d{9}$/',
                    'message' => '手机号不正确'
                ]
            ]),
            (new Field('email', 'E-Mail')),
        ];
    }

    /**
     * 保存账号设置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(['nickname', 'phone', 'email', 'password', 'avatar']);
        if (!empty($data['password'])) {
            Validator::make($request->all(), [
                'old_password' => ['required', 'current_password:manage'],
                'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->uncompromised(3)],
            ], [
                'required' => '新密码必须输入',
                'current_password' => '旧密码有误',
                'confirmed' => '两次输入的密码不一致',
                'password' => '新密码过于简单，请至少8位字符以上，并且需包含字母/数字'
            ])->validate();
        } else {
            $this->checkFormRules($request, true);
        }
        try {
            $this->dao()->update($data, auth('manage')->id());
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('保存成功.');
    }
}
