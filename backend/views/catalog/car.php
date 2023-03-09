<?php

use common\widgets\Alert;
use common\models\shop\Car;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = ($car == null) ? 'Новый автомобиль' : 'Редактирование автомобиля';
?>

<div class="form-block edit-block">
    <h4>
        <?= Html::encode($this->title) ?>
    </h4>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'car-form',
        'options' => [
            'class' => 'justify-content-center',
            'enctype' => 'multipart/form-data'
        ],
        'method' => 'post'
    ]); ?>

    <?php if ($car) : ?>
        <?= $form->field($model, 'isPopular')->checkbox([
            'template' => "<div class=\"text-center justify-content-center custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'yearOfRelease')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'rentalPrice')->textInput(['type' => 'number']); ?>

    <?= $form->field($model, 'placesCount')->textInput(['type' => 'number']); ?>

    <?= $form->field($model, 'transmission')->dropDownList(Car::TRANSMISSION_TYPES); ?>

    <?= $form->field($model, 'drive')->dropDownList(Car::DRIVE_TYPES); ?>

    <?= $form->field($model, 'power')->textInput(['type' => 'number']); ?>

    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control form-contol-file']); ?>

    <?php if ($car && $car->image) : ?>
        Текущее изображение: <?= Html::encode($car->image) ?>
        <div class="image-block">
            <img src="/images/cars/<?= Html::encode($car->image) ?>">
        </div>
    <?php endif; ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>