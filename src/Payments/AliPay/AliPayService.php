<?php
namespace Gentle\Edith\Payments;

use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Factory;
use Alipay\EasySDK\Kernel\Util\ResponseChecker;
use Gentle\Edith\Exceptions\PaymentException;
use Gentle\Edith\Exceptions\PaymentNotFoundException;
use Gentle\Edith\Models\EdithPay;
use Gentle\Edith\Models\EdithPayment;
use Gentle\Edith\Support\Str;

class AliPayService
{
    /**
     * 当前平台 ID 0为主平台
     * @var int|null
     */
    protected ?int $platform_id = null;

    /**
     * 支付通道
     * @var EdithPayment|null
     */
    protected ?EdithPayment $payment = null;

    /**
     * SDK 返回内容验证
     * @var ResponseChecker|null
     */
    protected ?ResponseChecker $responseChecker = null;

    /**
     * 发起支付模块
     * @var string
     */
    protected string $modules = 'default';

    /**
     * construct AliPay SDK
     * @param int $platform_id 平台ID 0为主平台
     */
    public function __construct(int $platform_id = 0, ?string $modules = 'default')
    {
        $this->platform_id = $platform_id;
        $this->modules = $modules ?: 'default';
        $this->responseChecker = new ResponseChecker();
    }

    /**
     * @param EdithPayment $payment
     * @return $this
     * @throws PaymentNotFoundException
     */
    public function setPayment(EdithPayment $payment)
    {
        if (strtolower($payment->channel) != 'alipay') {
            throw new PaymentNotFoundException('set current the Payment channel not is Alipay');
        }
        $this->payment = $payment;
        return $this;
    }

    /**
     * 获取当前支付通道模型
     * @return EdithPayment
     */
    public function getPayment(): EdithPayment
    {
        return $this->payment;
    }

    /**
     * 统一下单接口
     * @param string $subject 订单名称
     * @param string $outTradeNo 订单编号
     * @param float|string $totalAmount 订单金额
     * @param string|null $buyerId 用户ID
     * @return mixed
     * @throws PaymentException
     * @throws PaymentNotFoundException
     */
    public function create(string $subject, string $outTradeNo, $totalAmount, string $buyerId)
    {
        $this->buildAlipayConfig();
        if (!$this->responseChecker->success($result = Factory::payment()->common()->create($subject, $outTradeNo, strval($totalAmount), $buyerId))) {
            throw new PaymentException($result->msg . "，" . $result->sub_msg . PHP_EOL);
        }
        return $result;
    }

    /**
     * 面对面扫码预下单
     * @param string $subject 订单名称
     * @param string $outTradeNo 订单编号
     * @param float|string $totalAmount 订单金额
     * @param string|null $authCode 预授权 Code 留空则预下单返回订单信息
     * @return mixed
     * @throws PaymentException
     * @throws PaymentNotFoundException
     */
    public function faceToFace(string $subject, string $outTradeNo, $totalAmount, ?string $authCode = null)
    {
        $this->buildAlipayConfig('face');
        if (is_null($authCode)) {
            $result = Factory::payment()->faceToFace()->preCreate($subject, $outTradeNo, strval($totalAmount));
        } else {
            $result = Factory::payment()->faceToFace()->pay($subject, $outTradeNo, strval($totalAmount), $authCode);
        }
        if (!$this->responseChecker->success($result)) {
            throw new PaymentException($result->msg . "，" . $result->sub_msg . PHP_EOL);
        }
        return $result;
    }

    /**
     * H5 WAP 手机下单
     * @param string $subject 订单名称
     * @param string $outTradeNo 订单编号
     * @param float|string $totalAmount 订单金额
     * @param string|null $quitUrl 中途退出返回地址
     * @param string|null $returnUrl 同步回调地址
     * @return mixed
     * @throws PaymentException
     * @throws PaymentNotFoundException
     */
    public function wap(string $subject, string $outTradeNo, $totalAmount, ?string $quitUrl = null, ?string $returnUrl = null)
    {
        if (empty($quitUrl)) {
            $quitUrl = url('edith/payment/quited');
        }
        if (empty($returnUrl)) {
            $returnUrl = $this->payment['return_url'] ?: url('edith/payment/return');
        }
        $this->buildAlipayConfig('wap');
        if (!$this->responseChecker->success($result = Factory::payment()->wap()->pay($subject, $outTradeNo, strval($totalAmount), $quitUrl, $returnUrl))) {
            throw new PaymentException($result->msg . "，" . $result->sub_msg . PHP_EOL);
        }
        return $result;
    }

    /**
     * WEB PC 下单
     * @param string $subject 订单名称
     * @param string $outTradeNo 订单编号
     * @param float|string $totalAmount 订单金额
     * @param string|null $returnUrl 同步回调地址
     * @return mixed
     * @throws PaymentException
     * @throws PaymentNotFoundException
     */
    public function pc(string $subject, string $outTradeNo, $totalAmount, ?string $returnUrl = null)
    {
        empty($returnUrl) && $returnUrl = $this->payment['return_url'] ?: url('edith/payment/return');
        $this->buildAlipayConfig('pc');
        if (!$this->responseChecker->success($result = Factory::payment()->wap()->pay($subject, $outTradeNo, strval($totalAmount), $returnUrl))) {
            throw new PaymentException($result->msg . "，" . $result->sub_msg . PHP_EOL);
        }
        return $result;
    }

    /**
     * APP 下单接口
     * @param string $subject 订单名称
     * @param string $outTradeNo 订单编号
     * @param float|string $totalAmount 订单金额
     * @return mixed
     * @throws PaymentException
     * @throws PaymentNotFoundException
     */
    public function app(string $subject, string $outTradeNo, $totalAmount)
    {
        $this->buildAlipayConfig('app');
        if (!$this->responseChecker->success($result = Factory::payment()->wap()->pay($subject, $outTradeNo, strval($totalAmount)))) {
            throw new PaymentException($result->msg . "，" . $result->sub_msg . PHP_EOL);
        }
        return $result;
    }

    /**
     * 花呗下单接口
     * @param string $subject 订单名称
     * @param string $outTradeNo 订单编号
     * @param float|string $totalAmount 订单金额
     * @param string|null $buyerId 用户ID
     * @return mixed
     * @throws PaymentException
     * @throws PaymentNotFoundException
     */
    public function huabei(string $subject, string $outTradeNo, $totalAmount, string $buyerId)
    {
        $this->buildAlipayConfig('huabei');
        if (!$this->responseChecker->success($result = Factory::payment()->huabei()->create($subject, $outTradeNo, strval($totalAmount), $buyerId))) {
            throw new PaymentException($result->msg . "，" . $result->sub_msg . PHP_EOL);
        }
        return $result;
    }


    /**
     * @throws PaymentNotFoundException
     */
    public function buildAlipayConfig(?string $mode = null): Config
    {
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipay.com';
        $options->signType = 'RSA2';

        if (!$this->payment || !is_null($mode) && !in_array($this->payment->mode, ['ALL', strtoupper($mode)])) {
            $model = EdithPayment::query();
            $model->where('platform_id', $this->platform_id);
            if (!is_null($mode)) {
                $model->where(function ($query) use ($mode) {
                    $query->where('mode', strtoupper($mode ?: 'all'))->orWhere('mode', 'ALL');
                });
            }

            $payment = $model->where('channel','alipay')->where('status', 1)->where('modules', $this->modules ?: 'default')
                ->inRandomOrder()
                ->firstOrFail();

            $this->setPayment($payment);
        } else {
            $payment = $this->payment;
        }

        $options->appId = $payment['app_id'];
        $options->merchantPrivateKey = $payment['private_key'];

        if (!empty($payment['public_key'])) {
            // 非证书模式，赋值支付宝公钥字符串即可
             $options->alipayPublicKey = $payment['public_key'];
        } else {
            // 证书模式，读取证书
            $options->alipayCertPath = base_path($payment['public_cert_path']);
            $options->alipayRootCertPath = base_path($payment['root_key']);
            $options->merchantCertPath = base_path($payment['app_public_path']);
        }

        $notifyUrl = url('api/edith/payment/notify/alipay');
        if (!empty($payment['notify_url'])) {
            if (strpos($payment['notify_url'],'http') !== false) {
                $notifyUrl = 'http://'. $payment['notify_url'];
            } else {
                $notifyUrl = $payment['notify_url'];
            }
        }
        $options->notifyUrl = $notifyUrl;

        // 如存在 AES 密钥，设置AES密钥加密传输
        if (!empty($payment['aes_key'])) {
            $options->encryptKey = $payment['aes_key'];
        }
        return $options;
    }
}