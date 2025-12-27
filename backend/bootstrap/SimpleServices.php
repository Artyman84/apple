<?php

namespace backend\bootstrap;

use backend\contracts\mappers\IAppleMapper;
use backend\contracts\services\IAppleService;
use backend\contracts\services\IAuthService;
use backend\mappers\AppleMapper;
use backend\services\AppleService;
use backend\services\AuthService;
use Yii;
use yii\base\BootstrapInterface;

class SimpleServices implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public function bootstrap($app): void
    {
        $container = Yii::$container;
        $container->setSingleton(IAuthService::class, AuthService::class);
        $container->setSingleton(IAppleMapper::class, AppleMapper::class);
        $container->setSingleton(IAppleService::class, AppleService::class);
    }
}
