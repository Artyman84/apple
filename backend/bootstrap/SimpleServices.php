<?php

namespace backend\bootstrap;

use backend\contracts\services\IAuthService;
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
        $container->setSingleton(IAuthService::class, fn() => new AuthService());
    }
}
