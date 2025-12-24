<?php

namespace backend\forms\auth;

use yii\base\Model;

/**
 * LoginForm class
 */
class LoginForm extends Model
{
    /**
     * @var string|null
     */
    public string|null $username = null;
    /**
     * @var string|null
     */
    public string|null $password = null;
    /**
     * @var bool|null
     */
    public bool|null $rememberMe = true;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string'],
            [['rememberMe'], 'boolean'],
        ];
    }
}
