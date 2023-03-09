<?php

namespace frontend\models\forms\authentication;

use Yii;
use common\models\Client;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
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
                'filter' => ['status' => Client::STATUS_INACTIVE],
                'message' => 'Данный адрес электронной почты не привязан ни к одному аккаунту или уже подтверждён.'
            ],
        ];
    }

    public function sendEmail(): bool
    {
        $client = Client::findOne([
            'email' => $this->email,
            'status' => Client::STATUS_INACTIVE
        ]);

        if ($client === null)
            return false;

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $client]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Регистрация аккаунта ' . Yii::$app->name)
            ->send();
    }
}
