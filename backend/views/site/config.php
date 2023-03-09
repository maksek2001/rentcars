<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use common\widgets\Alert;

$this->title = 'Конфигурация сайта';
?>

<div class="form-block edit-block">
    <h4>
        <?= Html::encode($this->title) ?>
    </h4>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'config-form',
        'options' => [
            'class' => 'justify-content-center',
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($model, 'discountForSignup')->textInput() ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>