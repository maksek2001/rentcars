<?php

namespace frontend\models\forms\authentication;

use Yii;
use yii\base\Model;
use common\models\Client;

class PasswordResetRequestForm extends Model
{
    /** @var string */
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'exist',
                'targetClass' => '\common\models\Client',
                'filter' => ['status' => Client::STATUS_ACTIVE],
                'message' => 'Данный адрес электронной почты не привязан ни к одному аккаунту'
            ],
        ];
    }

    public function sendEmail(): bool
    {
        $client = Client::findOne([
            'status' => Client::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$client)
            return false;

        if (!Client::isPasswordResetTokenValid($client->password_reset_token)) {
            $client->generatePasswordResetToken();
            
            if (!$client->save())
                return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['client' => $client]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Сброс пароля ' . Yii::$app->name)
            ->send();
    }
}
