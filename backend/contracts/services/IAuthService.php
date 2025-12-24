<?php

namespace backend\contracts\services;

use backend\forms\auth\LoginForm;
use common\models\User;

interface IAuthService
{
    /**
     * @param LoginForm $form
     *
     * @return User
     */
    public function authenticate(LoginForm $form): User;
}
