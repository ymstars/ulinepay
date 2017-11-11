<?php

namespace Ymstars\UlinePay\Controllers;

use App\Http\Controllers\Controller;
use Ymstars\UlinePay\Entities\Wechat\Results\WxPayResultNotify;

/**
 * 通知控制器
 * Class PayController
 * @package Ymstars\UlinePay\Controllers
 */
abstract class PayController extends Controller
{
    //支付成功通知及操作
    public function payNotify()
    {
        $xml = file_get_contents('php://input');
        \Log::info($xml);
        $result = new WxPayResultNotify();
        $result->FromXml($xml);
        \Log::info(implode('__', $result->GetValues()));
        if ($result->checkReturnSuccess() && $result->checkResultSuccess()) {
            return $this->whenReceiveResultSuccess($result);
        }
    }

    //支付宝支付成功通知及操作
    public function aliPayNotify()
    {
        $xml = file_get_contents('php://input');
        \Log::info($xml);
        $result = new WxPayResultNotify();
        $result->FromXml($xml);
        if ($result->checkReturnSuccess() && $result->checkResultSuccess() && $result->GetTrade_state() === 'TRADE_SUCCESS') {
            return $this->whenReceiveResultSuccess($result);
        }
    }

    /**
     * 当接收通知成功时候的行为
     * @param WxPayResultNotify $result
     */
    protected abstract function whenReceiveResultSuccess(WxPayResultNotify $result);
}
