<?php

namespace backend\helper;

use backend\contracts\services\IAuthService;
use Exception;
use Yii;

class AppHelper
{
    /**
     * @return IAuthService
     *
     * @throws Exception
     */
    public static function getAuthService(): IAuthService
    {
        return Yii::$container->get(IAuthService::class);
    }
}
