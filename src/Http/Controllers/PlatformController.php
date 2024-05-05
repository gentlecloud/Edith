<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Action\Action;
use Gentle\Edith\Components\Amis\Action\Drawer;
use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\Form;
use Gentle\Edith\Components\Amis\Form\FormItem;
use Gentle\Edith\Components\Amis\Form\InputDate;
use Gentle\Edith\Components\Amis\Form\InputSwitch;
use Gentle\Edith\Components\Amis\Tabs;
use Gentle\Edith\Models\EdithPlatform;

class PlatformController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '平台';

    /**
     * @var string|null
     */
    protected ?string $modelName = EdithPlatform::class;

    /**
     * 生成 Crud 列表页面
     * @param Crud $crud
     * @return Crud
     * @throws \Exception
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('id', '序号')->width(60);
        $crud->column('logo', 'LOGO')->type('avatar')->src('${logo}');
        $crud->column('title', '平台名称');
        $crud->column('remark', '备注');
        $crud->column('status', '状态')->quickEdit([
            "mode" => "inline",
            'type' => 'switch',
            'onText' => '启用',
            'offText' => '禁用',
            'saveImmediately' => true
        ]);
        $crud->column('created_at', '创建时间');
        $crud->column('updated_at', '更新时间');

        $crud->operation()->rowOnlyEditDestroyAction('link', 'drawer', $this->controls());
        $crud->basicHeaderToolbar('drawer', '创建平台', $this->controls())->onlyBulkDeleteAction()->quickSaveItemApi();
        return $crud;
    }

    public function controls(): array
    {

        return (new Tabs)->tabs([
            [
                'title' => '基本信息',
                'tab' => [
                    (new FormItem('title', '平台名称'))->required(),
                    (new InputSwitch('status', '状态'))->onText('启用')->offText('禁用')->value(true),
                    new InputDate('expired_at', '到期时间'),
                    new FormItem('remark', '备注')
                ],
            ],
            [
                'title' => '微信公众号',
                'tab' => [
                    (new FormItem('app', '平台名称'))->required(),
                    (new FormItem('name', '平台名称'))->required(),
                    (new InputSwitch('status', '状态'))->onText('启用')->offText('禁用')->value(true),
                    new FormItem('remark', '备注')
                ]
            ]
        ])->render();
    }
}