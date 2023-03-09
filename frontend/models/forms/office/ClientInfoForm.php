<?php

namespace frontend\models\forms\office;

use Yii;
use DateTime;
use DateTimeZone;
use yii\base\Model;
use common\models\Client;

class ClientInfoForm extends Model
{
    /** @var string */
    public $fullname;

    /** @var string */
    public $birthDate;

    public function attributeLabels()
    {
        return [
            'fullname' => 'ФИО',
            'birthDate' => 'Дата рождения'
        ];
    }

    public function rules()
    {
        return [
            [['fullname', 'birthDate'], 'safe'],
            ['birthDate', 'validateBirthDate']
        ];
    }

    public function validateBirthDate($attribute)
    {
        $dateTimeZone = new DateTimeZone('Europe/Samara');

        $entered = new DateTime($this->birthDate, $dateTimeZone);
        $entered->modify("+18 years");
        $now = new DateTime('now', $dateTimeZone);

        if ($entered > $now) {
            $this->addError($attribute, 'Вам ещё не исполнилось 18 лет!');
        }
    }

    public function updateInfo(): bool
    {
        if (!$this->validate())
            return false;

        $client = Client::findOne(Yii::$app->user->id);

        $client->fullname = $this->fullname;
        $client->birth_date = $this->birthDate;

        return $client->save();
    }
}
