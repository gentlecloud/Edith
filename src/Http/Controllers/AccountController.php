<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Components\Fields\Field;
use Edith\Admin\Components\Fields\Item\Uploader;
use Edith\Admin\Components\Forms\ProForm;
use Edith\Admin\Components\Layouts\Menu;
use Edith\Admin\Components\Layouts\MenuItem;
use Edith\Admin\Components\Pages\PageContainer;
use Edith\Admin\Components\Pages\ProCard;
use Edith\Admin\Events\AccountRenderAfter;
use Edith\Admin\Events\AccountRenderBefore;
use Edith\Admin\Exceptions\DaoException;
use Edith\Admin\Exceptions\RendererException;
use Edith\Admin\Dao\AdminUserDao;
use Illuminate\Http\JsonResponse;
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
     * @throws RendererException|\Edith\Admin\Exceptions\DaoException
     */
    public function index(Request $request)
    {
        $before = new AccountRenderBefore();
        event($before);

        $user = (new AdminUserDao())->get(auth('manage')->id())
            ->makeHidden(['lasted_at', 'created_at', 'updated_at', 'log', 'platforms'])
            ->toArray();

        $menu = (new Menu())
            ->items(array_merge([
                (new MenuItem('账号设置', 'account')),
                (new MenuItem('安全设置', 'security')),
            ], $before->tabs->toArray()))
            ->style(['minHeight' => 600, 'borderInlineEnd' => 'none'])
            ->mode('inline')
            ->selectedKeys(['account']);

        $basicColumns = [
            (new ProCard())
                ->title('账号设置')
                ->body(array_merge($this->fields(), $before->fields->toArray()))
                ->visibleOn('includes(menu_select_key, \'account\')'),
            (new ProCard())
                ->title('安全设置')
                ->body(array_merge([
                    (new Field('old_password', '旧密码'))->component('password')->requiredOn('${!!old_password || !!password || !!password_confirmation}'),
                    (new Field('password', '新密码'))->component('password')->requiredOn('${!!old_password || !!password || !!password_confirmation}'),
                    (new Field('password_confirmation', '确认密码'))->component('password')->requiredOn('${!!old_password || !!password || !!password_confirmation}'),
                ], $before->securities->toArray()))
                ->visibleOn('includes(menu_select_key, \'security\')'),
        ];

        $after = new AccountRenderAfter($user);
        event($after);

        $form = (new ProForm())
            ->scopeName('account_form')
            ->initialValues(array_merge($user, $after->data->toArray()))
            ->columns(array_merge($basicColumns, $before->columns->toArray()));

        $card = (new ProCard())->split('vertical')->body([
            (new ProCard())->colSpan(['xs' => '50%', 'sm' => '30%', 'xl' => '20%'])->body($menu),
            (new ProCard())->body($form),
        ]);

        return engine((new PageContainer('账号设置'))->body($card));
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
     * @return JsonResponse
     * @throws DaoException
     */
    public function store(Request $request)
    {
        $data = $request->except($this->dao()->guard);
        $this->checkFormRules($request, true);
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
        }
        try {
            $this->dao()->update($data, auth('manage')->id());
        } catch (\Exception $e) {
            return error($e->getMessage());
        }
        return success('保存成功.');
    }
}
