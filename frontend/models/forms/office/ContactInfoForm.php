<?php

namespace frontend\models\forms\office;

use Yii;
use common\models\Client;
use yii\base\Model;

class ContactInfoForm extends Model
{
    /** @var string */
    public $email;

    /** @var string */
    public $phone;

    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона'
        ];
    }

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'validateEmail'],

            ['phone', 'safe'],
            ['phone', 'match', 'pattern' => '/^((\+7|7|8)+([0-9]){10})$/i', 'message' => 'Номер телефона должен быть в формате +7 XXX XXX XX XX'],
            ['phone', 'validatePhone'],
        ];
    }

    public function validateEmail($attribute)
    {
        if (!$this->hasErrors()) {
            $teamId = Client::findOne(['email' => $this->email])->id;
            if ($teamId != null && $teamId != Yii::$app->user->id) {
                $this->addError($attribute, 'Данный e-mail уже используется');
            }
        }
    }

    public function validatePhone($attribute)
    {
        if (!$this->hasErrors()) {
            $teamId = Client::findOne(['phone' => $this->phone])->id;
            if ($teamId != null && $teamId != Yii::$app->user->id) {
                $this->addError($attribute, 'Данный номер телефона уже используется');
            }
        }
    }

    public function updateInfo(): ?array
    {
        if (!$this->validate())
            return null;

        $client = Client::findOne(Yii::$app->user->id);

        $client->phone = $this->phone;

        if ($client->email !== $this->email) {
            $client->email = $this->email;
            $client->generateEmailVerificationToken();
            $client->status = Client::STATUS_INACTIVE;

            return [
                'success' => $client->save() && $this->sendEmail($client),
                'emailChanged' => true
            ];
        }

        return [
            'success' => $client->save(),
            'emailChanged' => false
        ];
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
            ->setSubject('Смена электронной почты ' . Yii::$app->name)
            ->send();
    }
}
