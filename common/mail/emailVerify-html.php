<?php

use yii\helpers\Html;

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['authentication/verify-email', 'token' => $client->verification_token]);
?>

<div>
    <p>Здравствуйте, <strong><?= Html::encode($client->username) ?></strong>!</p>

    <p>Для подтверждения вашей электронной почты вам нужно перейти по данной ссылке:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>