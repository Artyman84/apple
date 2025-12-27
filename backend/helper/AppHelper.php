<?php

namespace backend\helper;

use backend\contracts\services\IAppleService;
use backend\contracts\services\IAuthService;
use backend\exceptions\ApplicationException;
use Exception;
use Yii;

class AppHelper
{
    /**
     * @return IAuthService
     *
     * @throws ApplicationException
     */
    public static function getAuthService(): IAuthService
    {
        try {
            return Yii::$container->get(IAuthService::class);
        } catch (Exception $exception) {
            throw new ApplicationException('Не удалось получить сервис для работы с авторизацией', $exception);
        }
    }

    /**
     * @return IAppleService
     *
     * @throws ApplicationException
     */
    public static function getAppleService(): IAppleService
    {
        try {
            return Yii::$container->get(IAppleService::class);
        } catch (Exception $exception) {
            throw new ApplicationException('Не удалось получить сервис для работы с яблоками', $exception);
        }
    }
}
