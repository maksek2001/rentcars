<?php

use yii\helpers\Html;

$officeLink = Yii::$app->urlManager->createAbsoluteUrl(['office/rents']);
?>

<div>
    <p>Здравствуйте, <strong><?= Html::encode($client->username) ?></strong>!</p>

    <p>Вы арендовали автомобиль <strong><?= Html::encode($car->name) ?></strong></p>
    <p style="margin-left: 10px;">
        Время аренды: <?= Yii::$app->formatter->asDatetime($rent->start_datetime, "php:d-m-Y H:i:s")?> - <?= Yii::$app->formatter->asDatetime($rent->end_datetime, "php:d-m-Y H:i:s") ?>
    </p>
    <p style="margin-left: 10px;">Стоимость: <?= Html::encode($rent->total_price) ?> руб.</p>
    <p><strong>Напоминаем,</strong> что вам нужно взять оригиналы документов с собой (паспорт и водительское удостоверение).</p>

    <p>Вы можете управлять вашими арендами в <?= Html::a('личном кабинете', $officeLink) ?></p>
</div>