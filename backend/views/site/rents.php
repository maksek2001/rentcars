<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use common\models\shop\Rent;

?>

<?php if ($rents) : ?>
    <?php foreach ($rents as $rent) : ?>
        <div class="panel-info rent-block">
            <div class="info-control rent-header">
                <strong class="rent-number"> АРЕНДА <?= Html::encode($rent->id) ?> </strong>
                <p class="rent-period info-text pc-display">
                    <?= Html::encode($rent->startDatetime) . " - " . Html::encode($rent->endDatetime) ?>
                </p>
                <p data-text="<?= Rent::STATUSES_MESSAGES[$rent->status] ? Rent::STATUSES_MESSAGES[$rent->status]['admin_message'] : 'Такой статус изначально не был предусмотрен' ?>" class="rent-status rent-<?= Html::encode($rent->status) ?>">
                    <?= Rent::STATUSES_MESSAGES[$rent->status] ? Rent::STATUSES_MESSAGES[$rent->status]['status'] : 'Особый' ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-small bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                    </svg>
                </p>
            </div>
            <?php if ($rent->childSafetySeatCount) : ?>
                <div class="alert alert-warning">
                    Нужно <?= Yii::$app->inflection->pluralize($rent->childSafetySeatCount, 'детское кресло') ?>
                </div>
            <?php endif; ?>
            <p class="rent-period info-text mobile-display">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-medium bi bi-calendar" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                </svg>
                <?= Html::encode($rent->startDatetime) . " - " . Html::encode($rent->endDatetime) ?>
            </p>
            <div class="mobile-block car-name-container">
                <p class="car-name">
                    <?= Html::encode($rent->carName) ?>
                </p>
            </div>
            <div class="rent-info">
                <div class="rented-car">
                    <img class="car-image" src="/images/cars/<?= Html::encode($rent->carImage) ?>" alt='изображение автомобиля'>
                    <div class="car-info-container">
                        <p class='car-name desktop-block'>
                            <?= Html::encode($rent->carName) ?>
                        </p>
                        <p class='car-number'>Код автомобиля: <?= Html::encode($rent->carId) ?></p>
                    </div>
                </div>
                <div class="rent-right-block">
                    Cтоимость: <strong><?= Html::encode($rent->totalPrice) ?> ₽</strong>
                    <?php if ($rent->status == Rent::STATUS_ACTIVE || $rent->status == Rent::STATUS_PENDING) : ?>
                        <br>
                        <a href="<?= Url::toRoute(['site/complete-rent', 'id' => $rent->id]) ?>" class="confirm-link" data-message="Вы действительно хотите завершить аренду?">
                            Завершить аренду
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-medium bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-text rent-client-info">
                <div class="summary">
                    <strong><?= Html::encode($rent->client->email) ?></strong>
                </div>
                <div class="details">
                    <div>
                        <strong class="info-header">Основная информация</strong>
                        <div class="client-info">
                            <p class='text'><strong>ФИО:</strong> &nbsp;&nbsp;
                                <?= $rent->client->fullname ? Html::encode($rent->client->fullname) : 'Не указано' ?>
                            </p>
                            <p class='text'><strong>Дата рождения:</strong> &nbsp;&nbsp;
                                <?= $rent->client->birthDate ? Html::encode($rent->client->birthDate) : 'Не указана' ?>
                            </p>
                        </div>
                        <div class="divider-horizontal"></div>

                        <strong class="info-header">Контактная информация</strong>
                        <div class="client-info">
                            <p class='text'>
                                <strong>E-mail: </strong>
                                <?= Html::encode($rent->client->email) ?>
                            </p>
                            <p class='text'>
                                <strong>Номер телефона: </strong>
                                <?= $rent->client->phone ? Html::encode($rent->client->phone) : 'Не указан' ?>
                            </p>
                        </div>
                        <div class="divider-horizontal"></div>

                        <strong class="info-header">Паспортные данные</strong>
                        <div class="client-info">
                            <p class='text'><strong>Серия:</strong> &nbsp;&nbsp;
                                <?= $rent->client->passportSerie ? Html::encode($rent->client->passportSerie) : 'Не указана' ?>
                            </p>
                            <p class='text'><strong>Номер:</strong> &nbsp;&nbsp;
                                <?= $rent->client->passportNumber ? Html::encode($rent->client->passportNumber) : 'Не указан' ?>
                            </p>
                            <p class='text'><strong>Дата выдачи:</strong> &nbsp;&nbsp;
                                <?= $rent->client->passportIssueDate ? Html::encode($rent->client->passportIssueDate) : 'Не указана' ?>
                            </p>
                            <p class='text'><strong>Кем выдан:</strong> &nbsp;&nbsp;
                                <?= $rent->client->passportIssueOrganization ? Html::encode($rent->client->passportIssueOrganization) : 'Организация не указана' ?>
                            </p>
                            <p class='text'><strong>Код подразделения:</strong> &nbsp;&nbsp;
                                <?= $rent->client->passportOrganizationCode ? Html::encode($rent->client->passportOrganizationCode) : 'Не указан' ?>
                            </p>
                        </div>
                        <div class="divider-horizontal"></div>

                        <strong class="info-header">Водительское удостоверение</strong>
                        <div class="client-info">
                            <p class='text'><strong>Серия:</strong> &nbsp;&nbsp;
                                <?= $rent->client->licenseSerie ? Html::encode($rent->client->licenseSerie) : 'Не указана' ?>
                            </p>
                            <p class='text'><strong>Номер:</strong> &nbsp;&nbsp;
                                <?= $rent->client->licenseNumber ? Html::encode($rent->client->licenseNumber) : 'Не указан' ?>
                            </p>
                            <p class='text'><strong>Дата выдачи:</strong> &nbsp;&nbsp;
                                <?= $rent->client->licenseIssueDate ? Html::encode($rent->client->licenseIssueDate) : 'Не указана' ?>
                            </p>
                            <p class='text'><strong>Дата окончания действия:</strong> &nbsp;&nbsp;
                                <?= $rent->client->licenseExpirationDate ? Html::encode($rent->client->licenseExpirationDate) : 'Не указана' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($rent->status == Rent::STATUS_ACTIVE || $rent->status == Rent::STATUS_PENDING) : ?>
                <div class="mobile-block сancel-block">
                    <a style="color: #fff; width: 100%;" href="<?= Url::toRoute(['site/complete-rent', 'id' => $rent->id]) ?>" class="btn btn-success confirm-link" data-message="Вы действительно хотите завершить аренду?">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-medium bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                        </svg>
                        Завершить аренду
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <div class="alert alert-warning">
        Отсутствуют данные для отображения
    </div>
<?php endif; ?>