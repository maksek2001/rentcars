<?php

namespace common\models\client_info;

/**
 * Паспортные данные пользователя
 * 
 * @property int $client_id
 * @property string $serie
 * @property string $number
 * @property string $issue_date
 * @property string $issue_organization
 * @property string $issue_code
 * 
 */
class PassportInfo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{passports_info}}';
    }
}
