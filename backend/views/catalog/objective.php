<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use common\widgets\Alert;

$this->title = ($objective == null) ? 'Новая подкатегория' : 'Редактирование подкатегории';
?>

<div class="form-block edit-block">
    <h4>
        <?= Html::encode($this->title) ?>
    </h4>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'objective-form',
        'options' => [
            'class' => 'justify-content-center',
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>