<?php

use yii\helpers\Html;

$officeLink = Yii::$app->urlManager->createAbsoluteUrl(['office/rents']);
?>

<div>
    <p>Здравствуйте, <strong><?= Html::encode($client->username) ?></strong>!</p>

    <p>Ваша аренда была просрочена. Вы можете арендовать автомобиль на другое удобное вам время.</p>
</div>