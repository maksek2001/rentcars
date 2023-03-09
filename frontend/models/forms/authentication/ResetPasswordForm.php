<?php

namespace frontend\models\forms\authentication;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use Yii;
use common\models\Client;

class ResetPasswordForm extends Model
{
    public $password;

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль'
        ];
    }

    /** @var Client */
    private $_client;

    public function __construct(string $token, $config = [])
    {
        if (empty($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        
        $this->_client = Client::findByPasswordResetToken($token);

        if (!$this->_client) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }

        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['client.passwordMinLength']],
        ];
    }

    public function resetPassword(): bool
    {
        $client = $this->_client;
        
        $client->setPassword($this->password);
        $client->removePasswordResetToken();
        $client->generateAuthKey();

        return $client->save(false);
    }
}
