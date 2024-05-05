<?php
namespace Gentle\Edith\Http\Controllers;

use Gentle\Edith\Components\Amis\Crud;
use Gentle\Edith\Components\Amis\Form\Hidden;
use Gentle\Edith\Components\Amis\Form\InputFile;
use Gentle\Edith\Components\Amis\Form\InputNumber;
use Gentle\Edith\Components\Amis\Form\InputSwitch;
use Gentle\Edith\Components\Amis\Form\InputText;
use Gentle\Edith\Components\Amis\Form\Select;
use Gentle\Edith\Components\Amis\Form\Textarea;
use Gentle\Edith\Exceptions\RendererException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * @var string|null
     */
    protected ?string $title = '支付通道';

    /**
     * 控制器服务层
     * @var string|null
     */
    protected ?string $serviceName = "Gentle\Edith\Services\PaymentService";

    /**
     * @param Crud $crud
     * @return Crud
     * @throws RendererException
     */
    public function crud(Crud $crud): Crud
    {
        $crud->column('id', '序号')->sortable();
        $crud->column('title', '通道名称');
        $crud->column('name', '显示名称');
        $crud->column('code', '通道代码')->sortable();
        $crud->column('channel', '通道类型')->map([
            'alipay' => '支付宝',
            'wxpay' => '微信支付',
            'unionpay' => '云闪付',
        ]);
        $crud->column('method', '支付类型')->map([
            'common' => '通用',
            'pc' => '电脑',
            'mobile' => '手机',
            'app' => 'APP',
            'miniprogram' => '小程序',
            'scan' => '扫码'
        ]);
        $crud->column('mch_id', '商户ID')->sortable()->copyable();
        $crud->column('created_at', '添加时间')->sortable();

        $crud->operation()->rowOnlyEditDestroyAction('link', 'drawer', $this->controls());
        $crud->onlyBulkDeleteAction()->basicHeaderToolbar('drawer', '新增支付通道', $this->controls());

        return $crud;
    }

    /**
     * @return array
     * @throws RendererException
     */
    public function controls(): array
    {
        return [
            (new Hidden('platform_id'))->value(app('edith.platform')->id()),
            (new InputText('title', '通道名称'))->required(),
            (new InputText('name', '显示名称'))->required(),
            (new InputFile('logo', '显示图标')),
            (new Select('channel', '渠道'))->options([
                'alipay' => '支付宝',
                'wxpay' => '微信',
                'unionpay' => '银联/云闪付',
                'other' => '其他'
            ]),
            (new Select('method', '开通权限'))->multiple()->options([
                'APP' => 'APP',
                'JSAPI' => 'JSAPI/小程序/公众号',
                'WAP' => '手机WAP/H5',
                'PC' => '电脑端/PC',
                'QRCODE' => '扫码/付款码',
                'TRANSFER' => '转账打款',
                'HUA' => '花呗'
            ]),
            (new InputNumber('rate', '费率'))->displayMode('enhance')->precision(2),
            (new InputText('mch_id', '商户ID')),
            (new InputText('app_id', 'APPID'))->required(),
            (new Textarea('public_key', '公钥')),
            (new Textarea('private_key', '私钥')),
            (new InputText('aes_key', 'AES密钥'))->labelRemark('加密传输AES密钥'),
            (new InputFile('root_key', '根证书'))->labelRemark('如：支付宝根证书')->accept('application/x-x509-ca-cert')->receiver('api/finances/payment/upload?channel=${channel}&appId=${app_id}'),
            (new InputFile('public_cert_path', '公钥证书'))->labelRemark('如：支付宝公钥证书')->accept('application/x-x509-ca-cert')->receiver('api/finances/payment/upload?channel=${channel}&appId=${app_id}'),
            (new InputFile('app_public_path', '应用证书'))->labelRemark('如：支付宝应用证书')->accept('application/x-x509-ca-cert')->receiver('api/finances/payment/upload?channel=${channel}&appId=${app_id}'),
            (new InputText('notify_url', '回调链接'))->labelRemark('联系模块开发者确认'),
            (new InputText('return_url', '同步跳转')),
            (new InputSwitch('is_default', '默认通道'))->onText('默认')->offText('普通'),
            (new InputSwitch('is_recommend', '推荐通道'))->onText('推荐')->offText('普通'),
            (new InputSwitch('status', '状态'))->onText('启用')->offText('禁用')->value(1),
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();

        $saveFileName = $name;

        $channel = $request->input('channel') ?: 'default';
        $path = "cert/{$channel}";
        if (!empty($request->input('appId'))) {
            $path .= "/{$request->input('appId')}";
        } else {
            $saveFileName = Str::random(6) . '_' . $saveFileName;
        }

        $path = Storage::disk('local')->putFileAs($path, $file, $saveFileName);

        return success('上传成功', [
            'name' => $name,
            'value' => $path
        ]);
    }
}