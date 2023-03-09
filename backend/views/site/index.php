<?php

use yii\helpers\Url;
use common\models\shop\Rent;
use yii\bootstrap5\Html;

$this->title = Yii::$app->name;

?>

<div class="rents block-info">
    <div class="text-center">
        <p>Статус:</p>
        <div class="filter-block">
            <select id="status-select" class="filter-input form-control">
                <!-- Заданы вручную, вместо цикла, чтобы всегда "Активные" были при загрузке страницы -->
                <!-- (чтобы не зависеть от порядка в массиве STATUSES_MESSAGES) -->
                <option value="<?= Html::encode(Rent::STATUS_ACTIVE) ?>"><?= Html::encode(Rent::STATUSES_MESSAGES[Rent::STATUS_ACTIVE]['status']) ?></option>
                <option value="<?= Html::encode(Rent::STATUS_CANCELED) ?>"><?= Html::encode(Rent::STATUSES_MESSAGES[Rent::STATUS_CANCELED]['status']) ?></option>
                <option value="<?= Html::encode(Rent::STATUS_PENDING) ?>"><?= Html::encode(Rent::STATUSES_MESSAGES[Rent::STATUS_PENDING]['status']) ?></option>
                <option value="<?= Html::encode(Rent::STATUS_COMPLETED) ?>"><?= Html::encode(Rent::STATUSES_MESSAGES[Rent::STATUS_COMPLETED]['status']) ?></option>
                <option value="">Любой</option>
            </select>
        </div>
    </div>
    <div class="text-center mt-4">
        <p>Стоимость:</p>
        <div class="filter-block">
            <?= Html::textInput('', null, [
                'class' => 'filter-input form-control',
                'type' => 'number',
                'id' => 'min-price',
                'placeholder' => 'Минимум'
            ]) ?>
            <?= Html::textInput('', null, [
                'class' => 'filter-input form-control',
                'type' => 'number',
                'id' => 'max-price',
                'placeholder' => 'Максимум'
            ]) ?>
        </div>
    </div>
    <div class="text-center mt-4">
        <p>
            Период времени:
            <span class="explanation" data-text="Будут получены все аренды, пересекающиеся с данным периодом времени">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-small bi bi-info-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                </svg>
            </span>
        </p>
        <div class="filter-block">
            <?= Html::textInput('', null, [
                'class' => 'filter-input form-control',
                'type' => 'datetime-local',
                'id' => 'start-datetime'
            ]) ?>
            <?= Html::textInput('', null, [
                'class' => 'filter-input form-control',
                'type' => 'datetime-local',
                'id' => 'end-datetime'
            ]) ?>
        </div>
    </div>
    <div class="text-center">
        <?= Html::button('Найти', [
            'class' => "filter btn btn-primary",
            'data-url' => Url::toRoute('site/load-rents'),
            'id' => "filter"
        ]) ?>
    </div>
    <div id="rents">
        <?= $this->render('rents.php', ['rents' => $rents]); ?>
    </div>

    <?php $this->registerJsFile(
        '@web/js/rents.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    ); ?>
</div>