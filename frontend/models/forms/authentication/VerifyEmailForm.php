<?php

namespace frontend\models\forms\authentication;

use common\models\Client;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class VerifyEmailForm extends Model
{
    /** @var string */
    public $token;

    /** @var Client */
    private $_client;

    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }

        $this->_client = Client::findByVerificationToken($token);

        if (!$this->_client) {
            throw new InvalidArgumentException('Wrong verify email token.');
        }

        parent::__construct($config);
    }

    public function verifyEmail(): ?Client
    {
        $client = $this->_client;
        $client->status = Client::STATUS_ACTIVE;

        return $client->save(false) ? $client : null;
    }
}
