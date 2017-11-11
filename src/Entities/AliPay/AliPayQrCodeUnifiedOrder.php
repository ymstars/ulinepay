<?php
/**
 * Created by PhpStorm.
 * User: ymstars
 * Date: 2017/10/10
 * Time: 18:16
 */

namespace Ymstars\UlinePay\Entities\AliPay;

use Ymstars\UlinePay\Entities\Common\PayBase;


/**
 *
 * 支付宝扫码支付输入对象
 * @author widyhu
 *
 */
class AliPayQrCodeUnifiedOrder extends PayBase
{
    /**
     * 设置微信支付分配的商户号
     * @param string $value
     **/
    public function setMch_id($value)
    {
        $this->values['mch_id'] = $value;
    }

    /**
     * 获取微信支付分配的商户号的值
     * @return 值
     **/
    public function getMch_id()
    {
        return $this->values['mch_id'];
    }

    /**
     * 判断微信支付分配的商户号是否存在
     * @return true 或 false
     **/
    public function isMch_idSet()
    {
        return array_key_exists('mch_id', $this->values);
    }


    /**
     * 设置微信支付分配的终端设备号，商户自定义
     * @param string $value
     **/
    public function setDevice_info($value)
    {
        $this->values['device_info'] = $value;
    }

    /**
     * 获取微信支付分配的终端设备号，商户自定义的值
     * @return 值
     **/
    public function getDevice_info()
    {
        return $this->values['device_info'];
    }

    /**
     * 判断微信支付分配的终端设备号，商户自定义是否存在
     * @return true 或 false
     **/
    public function isDevice_infoSet()
    {
        return array_key_exists('device_info', $this->values);
    }


    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value
     **/
    public function setNonce_str($value)
    {
        $this->values['nonce_str'] = $value;
    }

    /**
     * 获取随机字符串，不长于32位。推荐随机数生成算法的值
     * @return 值
     **/
    public function getNonce_str()
    {
        return $this->values['nonce_str'];
    }

    /**
     * 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
     * @return true 或 false
     **/
    public function IsNonce_strSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     * 设置商品或支付单简要描述
     * @param string $value
     **/
    public function setBody($value)
    {
        $this->values['body'] = $value;
    }

    /**
     * 获取商品或支付单简要描述的值
     * @return 值
     **/
    public function getBody()
    {
        return $this->values['body'];
    }

    /**
     * 判断商品或支付单简要描述是否存在
     * @return true 或 false
     **/
    public function IsBodySet()
    {
        return array_key_exists('body', $this->values);
    }


    /**
     * 设置商品名称明细列表
     * @param string $value
     **/
    public function setDetail($value)
    {
        $this->values['detail'] = $value;
    }

    /**
     * 获取商品名称明细列表的值
     * @return 值
     **/
    public function getDetail()
    {
        return $this->values['detail'];
    }

    /**
     * 判断商品名称明细列表是否存在
     * @return true 或 false
     **/
    public function IsDetailSet()
    {
        return array_key_exists('detail', $this->values);
    }


    /**
     * 设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
     * @param string $value
     **/
    public function setOut_trade_no($value)
    {
        $this->values['out_trade_no'] = $value;
    }

    /**
     * 获取商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号的值
     * @return 值
     **/
    public function getOut_trade_no()
    {
        return $this->values['out_trade_no'];
    }

    /**
     * 判断商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号是否存在
     * @return true 或 false
     **/
    public function IsOut_trade_noSet()
    {
        return array_key_exists('out_trade_no', $this->values);
    }

    /**
     * 设置订单总金额，只能为整数，详见支付金额
     * @param string $value
     **/
    public function setTotal_fee($value)
    {
        $this->values['total_fee'] = $value;
    }

    /**
     * 获取订单总金额，只能为整数，详见支付金额的值
     * @return 值
     **/
    public function getTotal_fee()
    {
        return $this->values['total_fee'];
    }

    /**
     * 判断订单总金额，只能为整数，详见支付金额是否存在
     * @return true 或 false
     **/
    public function IsTotal_feeSet()
    {
        return array_key_exists('total_fee', $this->values);
    }


    /**
     * 设置APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。
     * @param string $value
     **/
    public function setSpbill_create_ip($value)
    {
        $this->values['spbill_create_ip'] = $value;
    }

    /**
     * 获取APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。的值
     * @return 值
     **/
    public function getSpbill_create_ip()
    {
        return $this->values['spbill_create_ip'];
    }

    /**
     * 判断APP和网页支付提交用户端ip，Native支付填调用微信支付API的机器IP。是否存在
     * @return true 或 false
     **/
    public function IsSpbill_create_ipSet()
    {
        return array_key_exists('spbill_create_ip', $this->values);
    }


    /**
     * 设置订单失效时间，取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）
     * @param string $value
     **/
    public function setTimeout_express($value)
    {
        $this->values['timeout_express'] = $value;
    }

    /**
     * 获取订单失效时间，取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）
     * @return //值
     **/
    public function getTimeout_express()
    {
        return $this->values['timeout_express'];
    }

    /**
     * 判断订单失效时间，取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）
     * @return true 或 false
     **/
    public function IsTimeout_expressSet()
    {
        return array_key_exists('timeout_express', $this->values);
    }


    /**
     * 禁止用户使用的支付渠道，多个渠道时使用",“分隔。
     * pcredit花呗，
     * pcreditpayInstallment花呗分期，
     * creditCard信用卡，
     * creditCardExpress信用卡快捷，
     * creditCardCartoon信用卡卡通，
     * credit_group信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期），
     * point积分，
     * voucher营销券，
     * promotion优惠（包含实时优惠+商户优惠）。
     * @param string $value
     **/
    public function setLimit_pay($value)
    {
        $this->values['limit_pay'] = $value;
    }

    /**
     * 禁止用户使用的支付渠道，多个渠道时使用",“分隔。
     * pcredit花呗，
     * pcreditpayInstallment花呗分期，
     * creditCard信用卡，
     * creditCardExpress信用卡快捷，
     * creditCardCartoon信用卡卡通，
     * credit_group信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期），
     * point积分，
     * voucher营销券，
     * promotion优惠（包含实时优惠+商户优惠）。
     * @return //值
     **/
    public function getLimit_pay()
    {
        return $this->values['limit_pay'];
    }

    /**
     * 禁止用户使用的支付渠道，多个渠道时使用",“分隔。
     * pcredit花呗，
     * pcreditpayInstallment花呗分期，
     * creditCard信用卡，
     * creditCardExpress信用卡快捷，
     * creditCardCartoon信用卡卡通，
     * credit_group信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期），
     * point积分，
     * voucher营销券，
     * promotion优惠（包含实时优惠+商户优惠）。
     * @return true 或 false
     **/
    public function IsLimit_paySet()
    {
        return array_key_exists('limit_pay', $this->values);
    }


    /**
     * 设置接收微信支付异步通知回调地址
     * @param string $value
     **/
    public function setNotify_url($value)
    {
        $this->values['notify_url'] = $value;
    }

    /**
     * 获取接收微信支付异步通知回调地址的值
     * @return 值
     **/
    public function getNotify_url()
    {
        return $this->values['notify_url'];
    }

    /**
     * 判断接收微信支付异步通知回调地址是否存在
     * @return true 或 false
     **/
    public function IsNotify_urlSet()
    {
        return array_key_exists('notify_url', $this->values);
    }
}