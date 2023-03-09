<?php

use backend\models\forms\CategoryForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use common\widgets\Alert;

$this->title = ($category == null) ? 'Новая категория' : 'Редактирование категории';
?>

<div class="form-block edit-block">
    <h4>
        <?= Html::encode($this->title) ?>
    </h4>

    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>

    <?php $form = ActiveForm::begin([
        'id' => 'category-form',
        'options' => [
            'class' => 'justify-content-center',
            'enctype' => 'multipart/form-data'
        ],
        'method' => 'post'
    ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <p>
        Допустимые форматы для иконки: <strong><?= implode(', ', CategoryForm::ICON_ADMISSIBLE_EXTENSIONS) ?></strong>
    </p>

    <?= $form->field($model, 'icon')->fileInput(['class' => 'form-control form-contol-file']) ?>

    <?php if ($category && $category->icon) : ?>
        Текущая иконка: <?= Html::encode($category->icon) ?>
        <div class="icon-block">
            <img src="/images/categories/icons/<?= Html::encode($category->icon) ?>">
        </div>
    <?php endif; ?>

    <p>
        Допустимые форматы для изображения: <strong><?= implode(', ', CategoryForm::IMAGE_ADMISSIBLE_EXTENSIONS) ?></strong>
    </p>

    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control form-contol-file']) ?>

    <?php if ($category && $category->image) : ?>
        Текущее изображение: <?= Html::encode($category->image) ?>
        <div class="image-block">
            <img src="/images/categories/<?= Html::encode($category->image) ?>">
        </div>
    <?php endif; ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>