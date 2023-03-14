<?php

use common\widgets\Alert;
use common\models\shop\Rent;
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "Личный кабинет " . Yii::$app->name;
?>
<div class="user-rents block-info">
    <?php Alert::begin(); ?>
    <?php Alert::end(); ?>
    <?php if ($rents) : ?>
        <?php foreach ($rents as $rent) : ?>
            <div class="panel-info rent-block">
                <div class="info-control rent-header">
                    <strong class="rent-number"> АРЕНДА <?= Html::encode($rent->id) ?> </strong>
                    <p class="rent-period info-text pc-display">
                        <?= Html::encode($rent->start_datetime) . " - " . Html::encode($rent->end_datetime) ?>
                    </p>
                    <p data-text="<?= Rent::STATUSES_MESSAGES[$rent->status] ? Rent::STATUSES_MESSAGES[$rent->status]['client_message'] : 'Такой статус изначально не был предусмотрен' ?>" class="rent-status rent-<?= $rent->status ?>">
                        <?= Rent::STATUSES_MESSAGES[$rent->status] ? Rent::STATUSES_MESSAGES[$rent->status]['status'] : 'Особый' ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-small bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                    </p>
                </div>
                <p class="rent-period info-text mobile-display">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-medium bi bi-calendar" viewBox="0 0 16 16">
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                    <?= Html::encode($rent->start_datetime) . " - " . Html::encode($rent->end_datetime) ?>
                </p>
                <div class="mobile-block car-name-container">
                    <a class='car-name' href="<?= Url::toRoute(['catalog/car', 'id' => $rent->car_id]) ?>">
                        <?= Html::encode($rentedCars[$rent->id]->name) ?>
                    </a>
                </div>
                <div class="rent-info">
                    <div class="rented-car">
                        <img class='car-image' src="/images/cars/<?= Html::encode($rentedCars[$rent->id]->image) ?>" alt='изображение автомобиля'>
                        <div class="car-info-container">
                            <a class='car-name desktop-block' href="<?= Url::toRoute(['catalog/car', 'id' => $rent->car_id]) ?>">
                                <?= Html::encode($rentedCars[$rent->id]->name) ?>
                            </a>
                            <div class="mobile-block">
                                <p class="rent-price"> Стоимость: <strong><?= Html::encode($rent->total_price) ?> ₽</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="rent-right-block">
                        Стоимость: <strong><?= Html::encode($rent->total_price) ?> ₽</strong>
                        <?php if ($rent->status == 'active') : ?>
                            <br>
                            <a class="confirm-link" data-message="Вы действительно хотите отменить аренду?" href="<?= Url::toRoute(['office/cancel-rent', 'id' => $rent->id]) ?>">
                                Отменить аренду
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-bottom: -4.5px;" class="icon-medium bi bi-x-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($rent->status == 'active') : ?>
                    <div class="mobile-block сancel-block">
                        <a style="color: #fff; width: 100%;" class="btn btn-danger confirm-link" data-message="Вы действительно хотите отменить аренду?" href="<?= Url::toRoute(['office/cancel-rent', 'id' => $rent->id]) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-medium bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                            Отменить аренду
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <nav>
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
                'options' => [
                    'class' => 'pagination justify-content-center',
                ],
                'pageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item next',
                'prevPageCssClass' => 'page-item prev',
            ]);
            ?>
        </nav>
    <?php else : ?>
        <div class="alert alert-warning" style="margin-top: 20px;">
            Вы пока не арендовали ни одного автомобиля
        </div>
    <?php endif; ?>
</div>