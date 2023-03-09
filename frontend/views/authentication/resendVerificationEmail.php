<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Повторный запрос на сброс пароля';
?>

<div class="form-block">
    <h3><?= Html::encode($this->title) ?></h3>

    <p class="mt-3">Пожалуйста, заполните свой адрес электронной почты. Туда будет отправлено электронное письмо с подтверждением.</p>

    <?php $form = ActiveForm::begin([
        'id' => 'resend-verification-email-form',
        'options' => [
            'class' => 'justify-content-center'
        ]
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>