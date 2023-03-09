<?php

namespace frontend\models\forms\office;

use Yii;
use common\models\client_info\PassportInfo;
use yii\base\Model;

class PassportForm extends Model
{
    /** @var string */
    public $serie;

    /** @var string */
    public $number;

    /** @var string */
    public $issueDate;

    /** @var string */
    public $issueOrganization;

    /** @var string */
    public $organizationCode;

    public function attributeLabels()
    {
        return [
            'serie' => 'Серия',
            'number' => 'Номер',
            'issueDate' => 'Дата выдачи',
            'issueOrganization' => 'Кем выдан',
            'organizationCode' => 'Код подразделения'
        ];
    }

    public function rules()
    {
        return [
            [['serie', 'number', 'issueDate', 'issueOrganization', 'organizationCode'], 'required', 'message' => 'Обязательное поле!'],
            [['serie'], 'string', 'length' => 4, 'notEqual' => 'Серия должна состоять из 4 цифр'],
            [['number'], 'string', 'length' => 6, 'notEqual' => 'Номер должен состоять из 6 цифр'],
            [['serie', 'number'], 'double', 'message' => 'Введено не число'],
            [['organizationCode'], 'string', 'length' => 7, 'notEqual' => 'Код подразделения должен быть в формате XXX-XXX'],
            [['serie', 'number'], 'match', 'pattern' => '/^[0-9]*$/i', 'message' => 'Введён недопустимый символ. Допустимые символы 0-9'],
            [['organizationCode'], 'match', 'pattern' => '/^[0-9]{3}-[0-9]{3}$/i', 'message' => 'Введён некорректный код подразделения'],
        ];
    }

    public function updateInfo(): bool
    {
        if (!$this->validate())
            return false;

        $passportInfo = PassportInfo::findOne(Yii::$app->user->id);

        if (!$passportInfo) {
            $passportInfo = new PassportInfo();
            $passportInfo->client_id = Yii::$app->user->id;
        }

        $passportInfo->serie = $this->serie;
        $passportInfo->number = $this->number;
        $passportInfo->issue_date = $this->issueDate;
        $passportInfo->issue_organization = $this->issueOrganization;
        $passportInfo->organization_code = $this->organizationCode;

        return $passportInfo->save();
    }
}
