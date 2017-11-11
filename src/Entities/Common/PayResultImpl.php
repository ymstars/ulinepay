<?php
/**
 * Created by PhpStorm.
 * User: ymstars
 * Date: 2017/10/10
 * Time: 18:15
 */

namespace Ymstars\UlinePay\Entities\Common;


/**
 *
 * 返回值基础类
 * @author widyhu
 *
 */
class PayResultImpl extends PayResults
{
    /**
     *
     * 设置错误码 FAIL 或者 SUCCESS
     * @param string
     */
    public function SetReturn_code($return_code)
    {
        $this->values['return_code'] = $return_code;
    }

    /**
     *
     * 获取错误码 FAIL 或者 SUCCESS
     * @return string $return_code
     */
    public function GetReturn_code()
    {
        return $this->values['return_code'];
    }

    /**
     * 判断是否返回正确
     * @return bool
     */
    public function checkReturnSuccess()
    {
        return $this->values['return_code'] === 'SUCCESS';
    }

    /**
     *
     * 设置错误信息
     * @param $return_msg
     */
    public function SetReturn_msg($return_msg)
    {
        $this->values['return_msg'] = $return_msg;
    }

    /**
     *
     * 获取错误信息
     * @return string
     */
    public function GetReturn_msg()
    {
        return $this->values['return_msg'];
    }

    /**
     *
     * 获取状态码
     */
    public function getResultCode()
    {
        return $this->values['result_code'];
    }

    /**
     *
     * 设置处理状态 FAIL 或者 SUCCESS
     * @param string
     */
    public function setResultCode($resultCode)
    {
        $this->values['result_code'] = $resultCode;
    }

    /**
     * 检查处理是否成功
     * @return bool
     */
    public function checkResultSuccess()
    {
        return $this->values['result_code'] === 'SUCCESS';
    }

    /**
     * 获取错误码
     */
    public function getErrorCode()
    {
        return $this->values['err_code'];
    }

    public function setErrorCode($errCode)
    {
        $this->values['err_code'] = $errCode;
    }

    /**
     * 获取错误信息
     */
    public function getErrorMsg()
    {
        return $this->values['err_msg'];
    }

    public function setErrorMsg($errMsg)
    {
        $this->values['err_msg'] = $errMsg;
    }

    /**
     * 获取错误信息
     */
    public function getErrCodeDes()
    {
        return $this->values['err_code_des'];
    }

    public function setErrCodeDes($des)
    {
        $this->values['err_code_des'] = $des;
    }
}