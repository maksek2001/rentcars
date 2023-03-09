<?php

namespace console\controllers;

use Yii;
use common\models\Client;
use DateTime;
use common\models\shop\Rent;
use DateTimeZone;
use yii\console\Controller;

class RentController extends Controller
{
    /**
     * Скрипт для обновления статусов аренд. Должен запускаться через планировщик задач.
     */
    public function actionUpdateRentsStatuses()
    {
        $rents = Rent::find()->where(['in', 'status', [Rent::STATUS_ACTIVE, Rent::STATUS_PENDING]])->all();

        if (!$rents) {
            echo "No car rental applications with the statuses 'Active' or 'Pending' were found \n";
            return;
        }

        foreach ($rents as $rent) {
            $dateTimeZone = new DateTimeZone('Europe/Samara');
            $now = new DateTime('now', $dateTimeZone);
            $endDatetime = new DateTime($rent->end_datetime,);
            $availableDate = (new DateTime($rent->end_datetime, $dateTimeZone))->modify(Rent::WAITING_TIME . ' hours');

            if ($endDatetime < $now) {
                if ($now < $availableDate && $rent->status == Rent::STATUS_ACTIVE) {
                    $rent->status = Rent::STATUS_PENDING;
                    $rent->save();
                } elseif ($now >= $availableDate) {
                    $rent->status = Rent::STATUS_OVERDUE;
                    $rent->save();
                    $this->sendEmail($rent);
                }
            }
        }

        echo "Updated car rental statuses \n";
    }

    private function sendEmail(Rent $rent): bool
    {
        $client = Client::findOne($rent->client_id);
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'overdueRent-html', 'text' => 'overdueRent-html'],
                ['client' => $client]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
            ->setTo($client->email)
            ->setSubject("Аренда автомобиля $rent->id " . Yii::$app->name)
            ->send();
    }
}
