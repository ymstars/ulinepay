<?php

namespace Ymstars\UlinePay;

use Ymstars\UlinePay\Entities\AliPay\AliPayCloseOrder;
use Ymstars\UlinePay\Entities\AliPay\AliPayJsApiUnifiedOrder;
use Ymstars\UlinePay\Entities\AliPay\AliPayQrCodeUnifiedOrder;
use Ymstars\UlinePay\Entities\Common\PayException;
use Ymstars\UlinePay\Entities\Common\PayResultImpl;
use Ymstars\UlinePay\Entities\Common\PayResults;
use Ymstars\UlinePay\Entities\Wechat\WxPayCloseOrder;
use Ymstars\UlinePay\Entities\Wechat\WxPayRefund;
use Ymstars\UlinePay\Entities\Wechat\WxPayRefundQuery;
use Ymstars\UlinePay\Entities\Wechat\WxPayUnifiedOrder;

class UlinePay
{
    const API_URL = 'http://api.cmbxm.mbcloud.com';

    /**
     * 统一返回成功回调返回
     * @return string
     */
    public static function generateSuccessCallBack()
    {
        return "<xml><return_code>SUCCESS</return_code></xml>";
    }

    /**
     * 统一返回成功回调返回
     * @param string $msg
     * @return string
     */
    public static function generateFailCallBack($msg = '')
    {
        return "<xml><return_code>FAIL</return_code><return_msg>" . $msg . "</return_msg></xml>";
    }

    /**
     *
     * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayUnifiedOrder $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public function unifiedOrderWx($inputObj, $timeOut = 6)
    {
        $url = UlinePay::API_URL . '/wechat/orders';
        //检测必填参数
        if (!$inputObj->IsOut_trade_noSet()) {
            throw new PayException("缺少统一支付接口必填参数out_trade_no！");
        } else if (!$inputObj->IsBodySet()) {
            throw new PayException("缺少统一支付接口必填参数body！");
        } else if (!$inputObj->IsTotal_feeSet()) {
            throw new PayException("缺少统一支付接口必填参数total_fee！");
        } else if (!$inputObj->IsTrade_typeSet()) {
            throw new PayException("缺少统一支付接口必填参数trade_type！");
        }

        //关联参数
        if ($inputObj->GetTrade_type() == "JSAPI" && !$inputObj->IsSubOpenidSet()) {
            throw new PayException("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
        }
        if ($inputObj->GetTrade_type() == "NATIVE" && !$inputObj->IsProduct_idSet()) {
            throw new PayException("统一支付接口中，缺少必填参数product_id！trade_type为JSAPI时，product_id为必填参数！");
        }

        //异步通知url未设置，则使用配置文件中的url
        if (!$inputObj->IsNotify_urlSet()) {
            $inputObj->SetNotify_url(config('ulinepay.notify_url.wx'));//异步通知url
        }

        $inputObj->SetSubAppid(config('ulinepay.weixin.app_id'));//公众账号ID
        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//终端ip
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        //签名
        $inputObj->SetSign();
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, false, $timeOut);
        $result = PayResultImpl::Init($response);
        return $result;
    }

    /**
     *
     * 关闭订单，WxPayCloseOrder中out_trade_no必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayCloseOrder $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public static function closeOrderWx($inputObj, $timeOut = 6)
    {
        $url = UlinePay::API_URL . '/wechat/orders/close';
        //检测必填参数
        if (!$inputObj->IsOut_trade_noSet()) {
            throw new PayException("订单查询接口中，out_trade_no必填！");
        }
        $inputObj->SetSubAppid(config('weixin.app_id'));//公众账号ID
        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, false, $timeOut);
        $result = PayResultImpl::Init($response);

        return $result;
    }

    /**
     *
     * 申请退款，WxPayRefund中out_trade_no、transaction_id至少填一个且
     * out_refund_no、total_fee、refund_fee、op_user_id为必填参数
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayRefund $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public static function refundWx($inputObj, $timeOut = 6)
    {
        $url = self::API_URL . '/wechat/refunds';
        //检测必填参数
        if (!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet()) {
            throw new PayException("退款申请接口中，out_trade_no、transaction_id至少填一个！");
        } else if (!$inputObj->IsOut_refund_noSet()) {
            throw new PayException("退款申请接口中，缺少必填参数out_refund_no！");
        } else if (!$inputObj->IsTotal_feeSet()) {
            throw new PayException("退款申请接口中，缺少必填参数total_fee！");
        } else if (!$inputObj->IsRefund_feeSet()) {
            throw new PayException("退款申请接口中，缺少必填参数refund_fee！");
        } else if (!$inputObj->IsOp_user_idSet()) {
            throw new PayException("退款申请接口中，缺少必填参数op_user_id！");
        }

        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, true, $timeOut);
        $result = PayResultImpl::Init($response);

        return $result;
    }

    /**
     *
     * 查询退款
     * 提交退款申请后，通过调用该接口查询退款状态。退款有一定延时，
     * 用零钱支付的退款20分钟内到账，银行卡支付的退款3个工作日后重新查询退款状态。
     * WxPayRefundQuery中out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayRefundQuery $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public static function refundQueryWx($inputObj, $timeOut = 6)
    {
        $url = UlinePay::API_URL . '/wechat/refunds/query';
        //检测必填参数
        if (!$inputObj->IsOut_refund_noSet() &&
            !$inputObj->IsOut_trade_noSet() &&
            !$inputObj->IsTransaction_idSet() &&
            !$inputObj->IsRefund_idSet()) {
            throw new PayException("退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！");
        }
        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, false, $timeOut);
        $result = PayResultImpl::Init($response);

        return $result;
    }


    /**
     *
     * 支付宝扫码支付，out_trade_no、body、total_fee
     * mchid、spbill_create_ip、nonce_str不需要填入
     * @param AliPayQrCodeUnifiedOrder $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public static function unifiedQrCodeOrderAliPay($inputObj, $timeOut = 6)
    {
        $url = UlinePay::API_URL . '/alipay/orders/precreate';
        //检测必填参数
        if (!$inputObj->IsOut_trade_noSet()) {
            throw new PayException("缺少统一支付接口必填参数out_trade_no！");
        } else if (!$inputObj->IsBodySet()) {
            throw new PayException("缺少统一支付接口必填参数body！");
        } else if (!$inputObj->IsTotal_feeSet()) {
            throw new PayException("缺少统一支付接口必填参数total_fee！");
        }

        //异步通知url未设置，则使用配置文件中的url
        if (!$inputObj->IsNotify_urlSet()) {
            $inputObj->SetNotify_url(config('ulinepay.notify_url.alipay'));//异步通知url
        }

        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//终端ip
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        //签名
        $inputObj->SetSign();
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, false, $timeOut);
        $result = PayResultImpl::Init($response);

        return $result;
    }

    /**
     *
     * 支付宝JsApi支付，out_trade_no、body、total_fee
     * mchid、spbill_create_ip、nonce_str不需要填入
     * @param AliPayJsApiUnifiedOrder $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public static function unifiedJsApiOrderAliPay($inputObj, $timeOut = 6)
    {
        $url = UlinePay::API_URL . '/alipay/orders/create';
        //检测必填参数
        if (!$inputObj->IsOut_trade_noSet()) {
            throw new PayException("缺少统一支付接口必填参数out_trade_no！");
        } else if (!$inputObj->IsBodySet()) {
            throw new PayException("缺少统一支付接口必填参数body！");
        } else if (!$inputObj->IsTotal_feeSet()) {
            throw new PayException("缺少统一支付接口必填参数total_fee！");
        }

        //异步通知url未设置，则使用配置文件中的url
        if (!$inputObj->IsNotify_urlSet()) {
            $inputObj->SetNotify_url(config('ulinepay.notify_url.alipay'));//异步通知url
        }

        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//终端ip
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        //签名
        $inputObj->SetSign();
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, false, $timeOut);
        $result = PayResults::Init($response);

        return $result;
    }

    /**
     *
     * 申请退款，WxPayRefund中out_trade_no、transaction_id至少填一个且
     * out_refund_no、total_fee、refund_fee、op_user_id为必填参数
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayRefund $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public static function refundAliPay($inputObj, $timeOut = 6)
    {
        $url = UlinePay::API_URL . '/alipay/refunds';
        //检测必填参数
        if (!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet()) {
            throw new PayException("退款申请接口中，out_trade_no、transaction_id至少填一个！");
        } else if (!$inputObj->IsOut_refund_noSet()) {
            throw new PayException("退款申请接口中，缺少必填参数out_refund_no！");
        } else if (!$inputObj->IsTotal_feeSet()) {
            throw new PayException("退款申请接口中，缺少必填参数total_fee！");
        } else if (!$inputObj->IsRefund_feeSet()) {
            throw new PayException("退款申请接口中，缺少必填参数refund_fee！");
        } else if (!$inputObj->IsOp_user_idSet()) {
            throw new PayException("退款申请接口中，缺少必填参数op_user_id！");
        }

        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, true, $timeOut);
        $result = PayResultImpl::Init($response);

        return $result;
    }

    /**
     *
     * 关闭订单，AliPayCloseOrder中out_trade_no必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param AliPayCloseOrder $inputObj
     * @param int $timeOut
     * @throws PayException
     * @return //成功时返回，其他抛异常
     */
    public static function closeOrderAliPay($inputObj, $timeOut = 6)
    {
        $url = UlinePay::API_URL . '/alipay/orders/close';
        //检测必填参数
        if (!$inputObj->IsOut_trade_noSet()) {
            throw new PayException("订单查询接口中，out_trade_no必填！");
        }
        $inputObj->SetMch_id(config('ulinepay.mch_id'));//商户号
        $inputObj->SetNonce_str(self::getNonceStr());//随机字符串

        $inputObj->SetSign();//签名
        $xml = $inputObj->ToXml();

        $response = self::postXmlCurl($xml, $url, false, $timeOut);
        $result = PayResults::Init($response);

        return $result;
    }


    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return //产生的随机字符串
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 直接输出xml
     * @param string $xml
     */
    public static function replyNotify($xml)
    {
        echo $xml;
    }

    /**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml 需要post的xml数据
     * @param string $url url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second url执行超时时间，默认30s
     * @return mixed
     * @throws PayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new PayException("curl出错，错误码:$error");
        }
    }

}
