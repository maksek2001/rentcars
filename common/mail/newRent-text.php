<?php

$officeLink = Yii::$app->urlManager->createAbsoluteUrl(['office/rents']);
?>

Здравствуйте, <?= $client->username ?>
    
Вы арендовали автомобиль <?= $car->name ?>

Время аренды: <?= Yii::$app->formatter->asDatetime($rent->start_datetime, "php:d-m-Y H:i:s")?> - <?= Yii::$app->formatter->asDatetime($rent->end_datetime, "php:d-m-Y H:i:s") ?>

Стоимость: <?= $rent->total_price ?>

Напоминаем, что вам нужно взять оригиналы документов с собой (паспорт и водительское удостоверение).
