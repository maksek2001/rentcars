<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Запрос на сброс пароля';
?>

<div class="form-block">
    <h3><?= Html::encode($this->title) ?></h3>

    <p class="mt-3">Пожалуйста, заполните свой адрес электронной почты. Туда будет отправлена ссылка для сброса пароля.</p>

    <?php $form = ActiveForm::begin([
        'id' => 'request-password-reset-form',
        'options' => [
            'class' => 'justify-content-center'
        ]
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>