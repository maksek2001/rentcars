<?php

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['authentication/verify-email', 'token' => $client->verification_token]);
?>

Здравствуйте, <?= $client->username ?>.

Для подтверждения вашей электронной почты вам нужно перейти по данной ссылке:

<?= $verifyLink ?>
