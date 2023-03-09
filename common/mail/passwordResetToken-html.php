<?php

use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['authentication/reset-password', 'token' => $client->password_reset_token]);
?>

<div>
    <p>Здравствуйте, <?= Html::encode($client->username) ?>.</p>

    <p>Для сброса текущего пароля вам необходимо перейти по данной ссылке:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
