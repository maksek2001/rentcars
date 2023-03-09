<?php

namespace frontend\models\forms\office;

use Yii;
use common\models\client_info\DrivingLicenseInfo;
use yii\base\Model;

class DrivingLicenseInfoForm extends Model
{
    /** @var string */
    public $serie;

    /** @var string */
    public $number;

    /** @var string */
    public $issueDate;

    /** @var string */
    public $expirationDate;

    public function attributeLabels()
    {
        return [
            'serie' => 'Серия',
            'number' => 'Номер',
            'issueDate' => 'Дата выдачи',
            'expirationDate' => 'Дата окончания действия'
        ];
    }

    public function rules()
    {
        return [
            [['serie', 'number', 'issueDate', 'expirationDate'], 'required', 'message' => 'Обязательное поле!'],
            [['serie'], 'string', 'length' => 4, 'notEqual' => 'Серия должна состоять из 4 цифр'],
            [['serie', 'number'], 'double', 'message' => 'Введено не число'],
            [['number'], 'string', 'length' => 6, 'notEqual' => 'Номер должен состоять из 6 цифр'],
            [['serie', 'number'], 'match', 'pattern' => '/^[0-9]*$/i', 'message' => 'Введён недопустимый символ. Допустимые символы 0-9'],
        ];
    }

    public function updateInfo(): bool
    {
        if (!$this->validate())
            return false;

        $licenseInfo = DrivingLicenseInfo::findOne(Yii::$app->user->id);

        if (!$licenseInfo) {
            $licenseInfo = new DrivingLicenseInfo();
            $licenseInfo->client_id = Yii::$app->user->id;
        }

        $licenseInfo->serie = $this->serie;
        $licenseInfo->number = $this->number;
        $licenseInfo->issue_date = $this->issueDate;
        $licenseInfo->expiration_date = $this->expirationDate;

        return $licenseInfo->save();
    }
}
