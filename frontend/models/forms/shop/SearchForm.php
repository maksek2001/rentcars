<?php

namespace frontend\models\forms\shop;

use DateTime;
use DateTimeZone;
use yii\base\Model;
use yii\helpers\Url;

class SearchForm extends Model
{
    /** @var string */
    public $startDatetime;

    /** @var string */
    public $endDatetime;

    public function attributeLabels()
    {
        return [
            'startDatetime' => 'Начало аренды',
            'endDatetime' => 'Окончание аренды'
        ];
    }

    public function rules()
    {
        return [
            [['startDatetime', 'endDatetime'], 'required', 'message' => 'Обязательное поле!'],

            ['startDatetime', 'validateStartDatetime'],
            ['endDatetime', 'validateEndDatetime']
        ];
    }

    public function validateStartDatetime($attribute)
    {
        $dateTimeZone = new DateTimeZone('Europe/Samara');

        $selected = new DateTime($this->startDatetime, $dateTimeZone);
        $selected->modify("-4 hours");
        $now = new DateTime('now', $dateTimeZone);

        if ($selected < $now) {
            $this->addError($attribute, 'Минимальное время, через которое можно забронировать автомобиль - 4 часа');
        }
    }

    public function validateEndDatetime($attribute)
    {
        $dateTimeZone = new DateTimeZone('Europe/Samara');

        $startDatetime = new DateTime($this->startDatetime, $dateTimeZone);
        $selected = new DateTime($this->endDatetime, $dateTimeZone);
        $now = new DateTime('now', $dateTimeZone);

        if ($this->startDatetime == null) {
            $this->addError($attribute, 'Сначала необходимо выбрать начальную дату');
            return;
        }

        if ($selected < $now || $selected <= $startDatetime) {
            $this->addError($attribute, 'Конечное время не должно быть раньше начального или быть равным ему');
        }
    }

    public function search(): ?string
    {
        if (!$this->validate())
            return null;

        return Url::toRoute(['catalog/search', 'startDatetime' => $this->startDatetime, 'endDatetime' => $this->endDatetime]);
    }
}
