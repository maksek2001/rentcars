<?php

namespace backend\models\forms;

use backend\models\Admin;
use Yii;
use yii\base\Model;

/**
 * Форма авторизации администратора
 */
class LoginForm extends Model
{
    /** @var string */
    public $username;

    /** @var string */
    public $password;

    /** @var Admin */
    private $_admin = null;

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Обязательное поле!'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute)
    {
        $this->getAdmin();

        if (!$this->_admin || !$this->_admin->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверный логин или пароль');
        }
    }

    public function login(): bool
    {
        if (!$this->validate())
            return false;

        return Yii::$app->user->login($this->_admin);
    }

    public function getAdmin()
    {
        if ($this->_admin === null)
            $this->_admin = Admin::findByUsername($this->username);
    }
}
