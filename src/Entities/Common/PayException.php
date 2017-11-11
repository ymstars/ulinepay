<?php

namespace Ymstars\UlinePay\Entities\Common;
/**
 *
 * 支付API异常类
 * @author widyhu
 *
 */
class PayException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}
