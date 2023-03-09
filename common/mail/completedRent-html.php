<?php

use yii\helpers\Html;

$officeLink = Yii::$app->urlManager->createAbsoluteUrl(['office/rents']);
?>

<div>
    <p>Здравствуйте, <strong><?= Html::encode($client->username) ?></strong>!</p>

    <p>Ваша аренда была успешно завершена. Надеемся, что вам всё понравилось.</p>

    <p>Спасибо, что выбрали нашу компанию.</p>
</div>