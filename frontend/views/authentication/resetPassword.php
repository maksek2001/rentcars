<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Сброс пароля';
?>

<div class="form-block">
    <h3><?= Html::encode($this->title) ?></h3>

    <p class="mt-3">Пожалуйста введите ваш новый пароль:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'reset-password-form',
        'options' => [
            'class' => 'justify-content-center'
        ]
    ]); ?>

    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>