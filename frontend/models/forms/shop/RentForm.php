<?php

namespace frontend\models\forms\shop;

use Yii;
use common\models\shop\Car;
use common\models\shop\Rent;
use common\models\Client;
use DateTime;
use DateTimeZone;
use yii\base\Model;

class RentForm extends Model
{
    /** @var int */
    public $carId;

    /** @var float */
    public $totalPrice;

    /** @var string */
    public $startDatetime;

    /** @var string */
    public $endDatetime;

    /** @var int */
    public $rentalPrice;

    /** @var int */
    public $childSafetySeatCount;

    public function attributeLabels()
    {
        return [
            'totalPrice' => 'Итоговая стоимость',
            'startDatetime' => 'Начало аренды',
            'endDatetime' => 'Окончание аренды',
            'childSafetySeatCount' => 'Количество детских кресел'
        ];
    }

    public function rules()
    {
        return [
            [['carId', 'startDatetime', 'endDatetime', 'rentalPrice', 'childSafetySeatCount', 'totalPrice'], 'required', 'message' => 'Обязательное поле!'],

            ['childSafetySeatCount', 'validateChildSafetySeatCount'],
            ['startDatetime', 'validatestartDatetime'],
            ['endDatetime', 'validateEndDatetime']
        ];
    }

    public function validateChildSafetySeatCount($attribute)
    {
        $car = Car::findOne($this->carId);

        if ($this->childSafetySeatCount > ($car->places_count - 1))
            $this->addError($attribute, 'В данном автомобиле нет такого количества пасажирских мест');

        if ($this->childSafetySeatCount < 0)
            $this->addError($attribute, 'Число не должно быть отрицательным');
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
            return;
        }

        $activeRents = Rent::findAllActiveRentsForCarByPeriod($this->startDatetime, $this->endDatetime, $this->carId);

        if (count($activeRents) > 0) {
            $activePeriods = $this->getActivePeriods($activeRents);
            $this->addError($attribute, "Данный период времени занят другими клиентами. Занятые периоды: $activePeriods");
        }
    }

    public function addRent(): array
    {
        if (!$this->validate())
            return [
                'success' => false,
                'message' => 'Введены неверные данные'
            ];

        $rent = new Rent();

        $rent->client_id = Yii::$app->user->id;
        $rent->car_id = $this->carId;
        $rent->total_price = $this->totalPrice;
        $rent->start_datetime = $this->startDatetime;
        $rent->child_safety_seat_count = $this->childSafetySeatCount;
        $rent->end_datetime = $this->endDatetime;
        $rent->created_at = date(Rent::DATETIME_DB_FORMAT);

        $rent->save();

        $this->sendEmail($rent);

        return [
            'success' => true,
            'message' => "Вы успешно арендовали автомобиль"
        ];
    }

    protected function sendEmail(Rent $rent): bool
    {
        $client = Client::findOne(Yii::$app->user->id);

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'newRent-html', 'text' => 'newRent-text'],
                ['rent' => $rent, 'client' => $client, 'car' => Car::findOne($rent->car_id)]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
            ->setTo($client->email)
            ->setSubject("Аренда автомобиля $rent->id " . Yii::$app->name)
            ->send();
    }

    private function getActivePeriods(array $rents): string
    {
        $periods = "";
        foreach ($rents as $rent) {
            $periods .= ' • ' . $rent['start_datetime'] . ' - ' . $rent['end_datetime'] . ' ';
        }

        return $periods;
    }
}
