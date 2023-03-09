<?php

$helpLink = Yii::$app->urlManager->createAbsoluteUrl(['help/index']);
?>
<?php $this->beginPage() ?>
<?php $this->beginBody() ?>
<?= Yii::$app->name ?>

<?= $content ?>

Данное сообщение было автоматически отправлено системой <?= Yii::$app->name ?>.

<?= $helpLink ?>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
