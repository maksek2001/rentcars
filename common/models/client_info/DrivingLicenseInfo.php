<?php

namespace common\models\client_info;

/**
 * Данные водительского удостоверения
 * 
 * @property int $client_id
 * @property string $serie
 * @property string $number
 * @property string $issue_date
 * @property string $expiration_date
 * 
 */
class DrivingLicenseInfo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{driving_licenses}}';
    }
}
