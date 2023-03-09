<?php

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['authentication/reset-password', 'token' => $client->password_reset_token]);
?>

Здравствуйте, <?= $client->username ?>.

Для сброса текущего пароля вам необходимо перейти по данной ссылке:

<?= $resetLink ?>
