<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use common\widgets\Alert;

$this->title = 'Панель администратора ' . Yii::$app->name;
?>
<div class="form-block">
    <h4><?= Html::encode($this->title) ?></h4>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary']) ?>


    <?php ActiveForm::end(); ?>

</div>