<?php
/**
 * Created by PhpStorm.
 * User: ymstars
 * Date: 2017/11/11
 * Time: 17:11
 */

return [
    /**
     * ------------------------------------------
     * 优畅商户ID
     * ------------------------------------------
     */
    'mch_id' => env('ULINE_MCH_ID', ''),
    /**
     * ------------------------------------------
     * 订单前缀
     * 为了区分不同渠道的订单支付行为，需要分开标识，避免重复
     * ------------------------------------------
     */
    'prefix' => [
        'ali_pay'   => env('ULINE_PREFIX_ALIPAY_PREFIX', 'aln_'),
        'wx_jsapi'  => env('ULINE_PREFIX_WX_JSAPI', 'wxj_'),
        'wx_native' => env('ULINE_PREFIX_WX_NATIVE', 'wxn_'),
    ],
    /*****
     * 微信公众号支付的APP ID
     */
    'weixin' => [
        'app_id' => env('ULINE_WEIXIN_APP_ID', ''),
    ],

];