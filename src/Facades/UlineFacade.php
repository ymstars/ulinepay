<?php
/**
 * Created by PhpStorm.
 * User: ymstars
 * Date: 2017/11/11
 * Time: 17:58
 */

namespace Ymstars\UlinePay\Facades;

use Illuminate\Support\Facades\Facade;

class UlineFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ulinepay';
    }
}