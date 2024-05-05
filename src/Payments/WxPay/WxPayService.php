<?php
namespace Gentle\Edith\Payments;

use Gentle\Edith\Exceptions\PaymentNotFoundException;
use Gentle\Edith\Exceptions\RequestErrorException;
use Gentle\Edith\Models\EdithPay;
use Gentle\Edith\Models\EdithPayment;
use Gentle\Edith\Support\Str;
use WeChatPay\Builder;
use WeChatPay\Crypto\AesGcm;
use WeChatPay\Crypto\Hash;
use WeChatPay\Crypto\Rsa;
use WeChatPay\Formatter;
use WeChatPay\Transformer;
use WeChatPay\Util\PemUtil;

class WxPayService
{
    /**
     * 当前平台 ID
     * @var int
     */
    protected $platform_id;

    /**
     * 当前支付模型
     * @var EdithPayment
     */
    protected $payment;

    /**
     * 微信商户ID
     * @var string
     */
    protected $mchid;

    /**
     * 微信支付商户 Secret
     * @var string
     */
    protected $secret;

    /**
     * 支付方式
     * @var string
     */
    protected $mode;

    /**
     * 回调链接
     * @var string
     */
    protected $notifyUrl;

    /**
     * 服务商子商户
     * @var array
     */
    protected array $merchant = [];

    /**
     * 微信支付实例
     * @var Builder
     */
    public $instance;

    /**
     * 初始化微信支付实例
     * @param int $platform_id
     * @param string | null $mode 支付方式
     */
    public function __construct(int $platform_id = 0, ?string $mode = null)
    {
        $this->platform_id = $platform_id;
        if (is_null($mode)) {
            $this->mode = $mode;
        }
        $this->notifyUrl = url('api/modules/payment/wechat/' . $platform_id);
    }

    /**
     * 获取当前微信商户绑定 APPID
     * @return EdithPayment
     */
    public function getPayment() : EdithPayment
    {
        return $this->payment;
    }

    /**
     * 设置当前支付通道
     * @param EdithPayment $payment
     * @return $this
     */
    public function setPayment(EdithPayment $payment) : WxPayService
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * 获取当前微信商户ID
     * @return string
     */
    public function getMchId() : string
    {
        return $this->mchid;
    }

    /**
     * 获取当前支付通道 APPID
     * @return string
     */
    public function getAppId() : string
    {
        return $this->payment['app_id'];
    }

    /**
     * 设置回调
     * @param string $notifyUrl
     * @return $this
     */
    public function setNotify(string $notifyUrl) : WxPayService
    {
        $this->notifyUrl = $notifyUrl;
        return $this;
    }

    /**
     * 设置服务商子商户
     * @param string $mchId 子商户商户ID
     * @param string $appid 子商户 APPID 非必 若传入 APPID 则 OPENID 为必填
     * @param string $openid 子商户 OPENID 非必 若传入 OPENID 则 APPID 为必填
     * @return $this
     */
    public function setSubMerchant(string $mchId,string $appid = '',string $openid = '') : WxPayService
    {
        $this->merchant = [
            'sub_mchid' => $mchId,
            'sub_appid' => $appid,
            'sub_openid' => $openid
        ];
        return $this;
    }

    /**
     * 统一下单
     * @param string $mode 支付方式 JSAPI | APP | H5 ...
     * @param array $order 订单数据
     * @return array 支付数据
     * @throws PaymentNotFoundException | RequestErrorException | \Exception
     */
    public function pay(string $mode,array $order) : array
    {
        if (empty($order['user_id'])) throw new \Exception('缺少必要参数: user_id');
        $this->mode = strtolower($mode);
        $this->init();
        $api = "v3/pay/partner/transactions/{$mode}";
        if (isset($this->merchant['sub_mchid'])) {
            $api = "v3/pay/partner/partner/transactions/{$mode}";
        }
        if (empty($order['sn']) && empty($order['out_trade_no'])) {
            $order['sn'] = Str::getOrderSn('NMP');
        }
        try {
            $json = $this->makePayJson($order);
            $resp = $this->instance
                ->chain($api)
                ->post(['json' => $this->makePayJson($order)]);
            EdithPay::create([
                'platform_id' => $this->platform_id,
                'user_id' => $order['user_id'],
                'sn' => $json['out_trade_no'],
                'title' => $json['description'],
                'money' => $order['price'] ?? $order['money'],
                'openid' => $json['payer']['openid'] ?? $json['payer']['sub_openid'],
                'payment_id' => $this->payment['id'],
                'pay_mode' => $mode,
                'hook' => $order['hook'] ?? null,
                'hook_params' => $order['hook_params'] ?? null,
                'modules' => $order['modules'] ?? ($this->platform_id == 0 ? 'main' : 'platform')
            ]);
            $res = $params = json_decode($resp->getBody() . PHP_EOL, true);
            if (in_array($this->mode, ['jsapi','app'])) {
                $params = [
                    'appId' => $json['appid'] ?? ($json['sub_appid'] ?? $json['sp_appid']),
                    'timeStamp' => (string) Formatter::timestamp(),
                    'nonceStr' => Formatter::nonce(),
                    'package' => "prepay_id={$res['prepay_id']}"
                ];
                $params += ['paySign' => Rsa::sign(
                    Formatter::joinedByLineFeed(...array_values($params)),
                    $this->merchantPrivateKeyInstance
                ), 'signType' => 'RSA'];
            }
        } catch (\Exception $e) {
            $err_msg = $e->getMessage();
            if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                $r = $e->getResponse();
                $rs = json_decode($r->getBody() . PHP_EOL, true);
                $err_msg = $rs['message'] ?? '未知错误';
            }
            throw new \Exception($err_msg, -80003);
        }

        return $params;
    }

    /**
     * 动态调用方法
     * @param $method
     * @param $parameters
     * @return false|mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * 构建下单 json 参数
     * @param $order
     * @return array
     * @throws \Exception
     */
    protected function makePayJson($order) : array
    {
        if (empty($order['price']) && empty($order['money'])) {
            throw new \Exception('缺少必要参数:支付金额', -80002);
        }
        if ($this->mode == 'jsapi' && empty($order['openid']) && empty($order['sub_openid'])) {
            throw new \Exception('缺少必要参数:OPENID', -80002);
        }
        if (empty($order['title']) && empty($order['description'])) {
            throw new \Exception('缺少必要参数:商品名称/描述', -80002);
        }
        $field = isset($this->merchant['sub_mchid']) ? 'sp_' : '';
        $data = [
            $field.'appid' => $this->payment['app_id'],
            $field.'mchid' => $this->mchid,
            'description' => $order['title'] ?? $order['description'],
            'out_trade_no' => $order['sn'] ?? $order['out_trade_no'],
            'attach' => $this->platform_id,
            'notify_url' => $this->notifyUrl,
            'amount' => [
                'total' => ($order['price'] ?? $order['money']) * 100,
                'currency' => $order['currency'] ?? 'CNY'
            ]
        ];

        if ((!empty($this->merchant['sub_openid']) || !empty($order['sub_openid'])) && !empty($this->merchant['sub_appid'])) {
            $data['sub_appid'] = $this->merchant['sub_appid'];
            $data['payer'] = ['sub_openid' => $order['sub_openid'] ?? $this->merchant['sub_openid']];
        } else {
            $data['payer'] = ['openid' => $order['openid']];
        }
        /**
         * 其他订单可选参数 所有可选参数合并传入
         * 如：[ 'goods_tag' => 'WXG', 'detail' => [ 'cost_price' => 1 ], 'scene_info' => [ 'payer_client_ip' => '8.8.8.8' ] ]
         */
        if (isset($order['other_params']) && is_array($order['other_params'])) {
            $data += $order['other_params'];
        }
        return $data;
    }

    /**
     * 初始化实例
     * @return $this
     * @throws PaymentNotFoundException
     */
    protected function init(): WxPayService
    {
        if (!$this->payment) {
            $payment = EdithPayment::where('platform_id', $this->platform_id)->where(function ($query) {
                $query->where(['mode' => strtoupper($this->mode), 'status' => 1])->orWhere(['mode' => 'ALL', 'status' => 1]);
            })->first();
            if (!$payment) {
                throw new PaymentNotFoundException('支付通道不存在！');
            }
            $this->payment = $payment;
        }

        $this->mchid = $this->payment['mch_id'];
        $path = $this->platform_id == 0 ? 'website' : 'modules';
        $privateFile = !empty($this->payment['private_key']) ? $this->payment['private_key'] : "cert/{$path}/wechat/{$this->mchid}/apiclient_key.pem";
        $merchantPrivateKeyFilePath = "file://" . base_path($privateFile);
        $merchantPrivateKeyInstance = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);
        $merchantCertificateSerial = $this->payment['payment_cert'];
        $platformCertificateFilePath = "file://" . base_path("cert/{$path}/wechat/wechatpay_{$this->payment['platform_sn']}.pem");
        $platformPublicKeyInstance = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);

        $platformCertificateSerial = PemUtil::parseCertificateSerialNo($platformCertificateFilePath);
        // 构造一个 APIv3 客户端实例
        $this->instance = Builder::factory([
            'mchid'      => $this->mchid,
            'serial'     => $merchantCertificateSerial,
            'privateKey' => $merchantPrivateKeyInstance,
            'certs'      => [
                $platformCertificateSerial => $platformPublicKeyInstance,
            ],
        ]);

        return $this;
    }
}