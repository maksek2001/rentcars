<?php

$this->title = Yii::$app->name;
?>
<div class="catalog-container">
    <?= $this->render('carBlock.php', ['car' => $car]) ?>
</div>