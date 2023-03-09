<?php

namespace frontend\models\forms\authentication;

use Yii;
use yii\base\Model;
use common\models\Client;

class SignupForm extends Model
{
    /** @var string */
    public $username;

    /** @var string */
    public $email;

    /** @var string */
    public $password;

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Client', 'message' => 'Данное имя пользователя уже используется'],
            ['username', 'string', 'length' => [2, 255]],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Client', 'message' => 'Данный email уже используется'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['client.passwordMinLength']],
        ];
    }

    public function signup(): bool
    {
        if (!$this->validate())
            return false;

        $client = new Client();
        $client->username = $this->username;
        $client->email = $this->email;
        $client->setPassword($this->password);
        $client->generateAuthKey();
        $client->generateEmailVerificationToken();

        return $client->save() && $this->sendEmail($client);
    }

    protected function sendEmail(Client $client): bool
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['client' => $client]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Регистрация аккаунта ' . Yii::$app->name)
            ->send();
    }
}
