<?php

namespace backend\models;

use yii\base\NotSupportedException;
use Yii;

/**
 * Администратор
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $status
 * @property string $email
 * 
 */
class Admin extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';

    public static function tableName()
    {
        return '{{admins}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    }

    public static function findByUsername(string $username)
    {
        return static::find()->where(['username' => $username])->one();
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
