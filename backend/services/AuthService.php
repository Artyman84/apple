<?php

namespace backend\services;

use backend\contracts\services\IAuthService;
use backend\forms\auth\LoginForm;
use common\models\User;
use DomainException;

/**
 * AuthService class
 */
readonly class AuthService implements IAuthService
{
    /**
     * {@inheritdoc}
     */
    public function authenticate(LoginForm $form): User
    {
        $user = User::findByUsername($form->username);

        if (is_null($user) || $user->isDeleted() || false === $user->validatePassword($form->password)) {
            throw new DomainException('Неверный логин или пароль.');
        }

        if ($user->isDisabled()) {
            throw new DomainException('Ваш аккаунт заблокирован.');
        }

        return $user;
    }
}
