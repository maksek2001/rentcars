<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use common\widgets\Alert;

$this->title = 'Авторизация';
?>
<div class="form-block">
    <h3><?= Html::encode($this->title) ?></h3>

    <p>Пожалуйста, заполните поля для авторизации</p>

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

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"text-center justify-content-center custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ]) ?>

    <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary']) ?>

    <div class="mt-3 my-1 mx-0 forgot-password">
        Забыли пароль? <?= Html::a('Сбросить пароль', ['authentication/request-password-reset']) ?>
    </div>

    <div class="mt-3 my-1 mx-0 forgot-password">
        Нужно новое сообщение для подтверждения электронной почты?
        <br>
        <?= Html::a('Отправить заново', ['authentication/resend-verification-email']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>