<?php
/**
 * Created by PhpStorm.
 * User: ymstars
 * Date: 2017/10/10
 * Time: 18:18
 */

namespace Ymstars\UlinePay\Entities\Wechat\Results;

use Ymstars\UlinePay\Entities\Common\PayResultImpl;
/**
 *
 * 关闭订单输入对象
 * @author widyhu
 *
 */
class WxPayResultNotify extends PayResultImpl
{
    /**
     * 设置微信分配的公众账号ID
     * @param string $value
     **/
    public function SetSubAppid($value)
    {
        $this->values['sub_appid'] = $value;
    }

    /**
     * 获取微信分配的公众账号ID的值
     * @return 值
     **/
    public function GetSubAppid()
    {
        return $this->values['sub_appid'];
    }

    /**
     * 判断微信分配的公众账号ID是否存在
     * @return true 或 false
     **/
    public function IsSubAppidSet()
    {
        return array_key_exists('sub_appid', $this->values);
    }


    /**
     * 设置微信支付分配的商户号
     * @param string $value
     **/
    public function SetMch_id($value)
    {
        $this->values['mch_id'] = $value;
    }

    /**
     * 获取微信支付分配的商户号的值
     * @return 值
     **/
    public function GetMch_id()
    {
        return $this->values['mch_id'];
    }

    /**
     * 判断微信支付分配的商户号是否存在
     * @return true 或 false
     **/
    public function IsMch_idSet()
    {
        return array_key_exists('mch_id', $this->values);
    }


    /**
     * 设置商户系统内部的订单号
     * @param string $value
     **/
    public function SetOut_trade_no($value)
    {
        $this->values['out_trade_no'] = $value;
    }

    /**
     * 获取商户系统内部的订单号的值
     * @return 值
     **/
    public function GetOut_trade_no()
    {
        return $this->values['out_trade_no'];
    }

    /**
     * 判断商户系统内部的订单号是否存在
     * @return true 或 false
     **/
    public function IsOut_trade_noSet()
    {
        return array_key_exists('out_trade_no', $this->values);
    }


    /**
     * 设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
     * @param string $value
     **/
    public function SetNonce_str($value)
    {
        $this->values['nonce_str'] = $value;
    }

    /**
     * 获取商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号的值
     * @return 值
     **/
    public function GetNonce_str()
    {
        return $this->values['nonce_str'];
    }

    /**
     * 判断商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号是否存在
     * @return true 或 false
     **/
    public function IsNonce_strSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     * 设置订单总金额，只能为整数，详见支付金额
     * @param string $value
     **/
    public function SetTotal_fee($value)
    {
        $this->values['total_fee'] = $value;
    }

    /**
     * 获取订单总金额，只能为整数，详见支付金额的值
     * @return 值
     **/
    public function GetTotal_fee()
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
     * 设置符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * @param string $value
     **/
    public function SetFee_type($value)
    {
        $this->values['fee_type'] = $value;
    }

    /**
     * 获取符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型的值
     * @return 值
     **/
    public function GetFee_type()
    {
        return $this->values['fee_type'];
    }

    public function GetTime_end()
    {
        return $this->values['time_end'];
    }

    public function SetTime_end($value)
    {
        $this->values['time_end'] = $value;
    }

    public function GetOutTransactionId()
    {
        return $this->values['out_transaction_id'];
    }

    public function SetOutTransactionId($value)
    {
        return $this->values['out_transaction_id'] = $value;
    }

    public function GetTransactionId()
    {
        return $this->values['transaction_id'];
    }

    public function SetTransactionId($value)
    {
        return $this->values['transaction_id'] = $value;
    }

    public function GetTrade_state()
    {
        return $this->values['trade_state'];
    }

    public function SetTrade_state($value)
    {
        return $this->values['trade_state'] = $value;
    }

    public function IsTrade_stateSet()
    {
        return array_key_exists('trade_state', $this->values);
    }
}