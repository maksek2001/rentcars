<?php

namespace frontend\models\forms\authentication;

use common\models\Client;
use Yii;
use yii\base\Model;

/**
 * Форма авторизации пользователя
 */
class LoginForm extends Model
{
    const REMEMBER_TIME = 3600 * 24 * 30;

    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var bool */
    public $rememberMe = false;

    /** @var Client */
    private $_client = null;

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Обязательное поле!'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $client = $this->getClient();

            if (!$client || !$client->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный логин или пароль');
            }
        }
    }

    public function login(): bool
    {
        if (!$this->validate())
            return false;

        return Yii::$app->user->login($this->getClient(),  $this->rememberMe ? self::REMEMBER_TIME : 0);
    }

    public function getClient(): ?Client
    {
        if ($this->_client === null)
            $this->_client = Client::findByUsername($this->username);

        return $this->_client;
    }
}
