<?php

namespace backend\services;

use backend\contracts\services\IAuthService;
use backend\forms\auth\LoginForm;
use common\models\User;
use DomainException;
use Yii;

/**
 * AuthService class
 */
class AuthService implements IAuthService
{
    /**
     * {@inheritdoc}
     */
    public function authenticate(LoginForm $form): User
    {
        $user = User::findByUsername($form->username);

        if (is_null($user) || $user->isDeleted() || false === $user->validatePassword($form->password)) {
            throw new DomainException(Yii::t('app', 'Неверный логин или пароль.'));
        }

        if ($user->isDisabled()) {
            throw new DomainException(Yii::t('app', 'Ваш аккаунт заблокирован.'));
        }

        return $user;
    }
}
