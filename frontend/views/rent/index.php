<?php

use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Аренда автомобиля';
?>

<div class="form-block rent-car-form">
    <h4>
        <?= Html::encode($this->title) ?>
    </h4>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php if ($hasDiscount) : ?>
        <div class="alert alert-success">
            Была применена скидка <?= Html::encode($discount) * 100 ?>%
        </div>
    <?php endif; ?>

    <h5> Выбранный автомобиль:</h5>
    <div class="selected-car">
        <div class="car-image"><img src="/images/cars/<?= Html::encode($car->image) ?>"></div>
        <div class="car-name"><?= Html::encode($car->name) ?></div>
        <div class="car-price">
            <?php if ($hasDiscount) : ?>
                <?= Html::encode($newPrice) ?>
            <?php else : ?>
                <?= Html::encode($car->rental_price) ?> ₽
            <?php endif; ?>
        </div>
    </div>

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'validationUrl' => ['rent/validate-rent'],
        'id' => 'rent-form',
        'options' => [
            'class' => 'justify-content-center'
        ],
        'method' => 'post'
    ]); ?>

    <div class="d-none">
        <?= $form->field($model, 'carId')->textInput() ?>

        <?= $form->field($model, 'rentalPrice')->textInput(['id' => 'rental-price']) ?>
    </div>

    <div class="dates">
        <?= $form->field($model, 'startDatetime')->textInput(['type' => 'datetime-local', 'class' => 'date form-control rent-input start-datetime']) ?>

        <?= $form->field($model, 'endDatetime')->textInput(['type' => 'datetime-local', 'class' => 'date form-control rent-input end-datetime']) ?>
    </div>

    <?= $form->field($model, 'childSafetySeatCount')->textInput(['class' => 'form-control', 'type' => 'number']) ?>

    <?= HTML::button('Рассчитать стоимость', ['id' => 'calculate-price', 'class' => 'btn btn-primary rent-button']) ?>

    <?= $form->field($model, 'totalPrice')->textInput(['class' => 'price form-control rent-input', 'id' => 'total-price', 'readonly' => true]) ?>

    <?= Html::submitButton('Арендовать автомобиль', ['class' => 'btn btn-primary rent-button', 'id' => 'rent', 'disabled' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>