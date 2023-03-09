<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Клиент
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property string $fullname
 * @property string $birth_date
 * @property string $phone
 */
class Client extends ActiveRecord implements IdentityInterface
{
    public const STATUS_BLOCKED = 'blocked';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_ACTIVE = 'active';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{clients}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_BLOCKED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->where(['id' => $id])
            ->andWhere(['<>', 'status', self::STATUS_BLOCKED])
            ->one();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername(string $username)
    {
        return static::find()
            ->where(['username' => $username])
            ->andWhere(['<>', 'status', self::STATUS_BLOCKED])
            ->one();
    }

    public static function findByPasswordResetToken(string $token)
    {
        if (!static::isPasswordResetTokenValid($token))
            return null;

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);

        return static::find()
            ->where(['password_reset_token' => $token])
            ->andWhere(['<>', 'status', self::STATUS_BLOCKED])
            ->one();
    }

    public static function findByVerificationToken(string $token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public static function isPasswordResetTokenValid(?string $token): bool
    {
        if (empty($token) || $token == null)
            return false;

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['client.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
