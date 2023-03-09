<?php

use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = "Личный кабинет " . Yii::$app->name;
?>

<div class="client-info block-info">
    <div class="panel-info">
        <div class="team-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-person bi bi-person-check-fill" viewBox="0 0 16 16">
                <path style="color: #00cc00;" fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                <path style="color: #a7a7a7;" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
            </svg>
            <div class="info">
                <h5><strong class="client-name"><?= Html::encode($client->username) ?></strong></h5>
            </div>
        </div>
    </div>

    <div class="contacts-info panel-info">
        <strong class="block-name">Контактная информация</strong>
        <?php Alert::begin(['options' => [
            'class' => 'inactive-client-message'
        ]]); ?>
        <?php Alert::end(); ?>
        <?php $form = ActiveForm::begin([
            'action' => ['edit-client-info/contact-save'],
            'enableAjaxValidation' => true,
            'validationUrl' => ['edit-client-info/validate-contact'],
            'id' => 'contact-info-form',
            'options' => [
                'class' => 'justify-content-center info-form contact-form'
            ],
            'method' => 'post'
        ]); ?>

        <?= $form->field($contactInfoForm, 'email')->textInput() ?>

        <?= $form->field($contactInfoForm, 'phone')->textInput() ?>

        <div class="submit-wrap">
            <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="panel-info">
        <strong class="block-name">Основная информация</strong>
        <?php $form = ActiveForm::begin([
            'action' => ['edit-client-info/main-save'],
            'enableAjaxValidation' => true,
            'validationUrl' => ['edit-client-info/validate-main'],
            'id' => 'client-info-form',
            'options' => [
                'class' => 'justify-content-center info-form ajax-form'
            ],
            'method' => 'post'
        ]); ?>

        <?= $form->field($clientInfoForm, 'fullname')->textInput() ?>

        <?= $form->field($clientInfoForm, 'birthDate')->textInput(['type' => 'date']) ?>

        <div class="submit-wrap">
            <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="panel-info">
        <strong class="block-name">Водительское удостоверение</strong>

        <?php $form = ActiveForm::begin([
            'action' => ['edit-client-info/license-save'],
            'id' => 'license-info-form',
            'options' => [
                'class' => 'justify-content-center info-form ajax-form'
            ],
            'method' => 'post'
        ]); ?>

        <?= $form->field($licenseInfoForm, 'serie')->textInput() ?>

        <?= $form->field($licenseInfoForm, 'number')->textInput() ?>

        <?= $form->field($licenseInfoForm, 'issueDate')->textInput(['type' => 'date']) ?>

        <?= $form->field($licenseInfoForm, 'expirationDate')->textInput(['type' => 'date']) ?>

        <div class="submit-wrap">
            <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="panel-info">
        <strong class="block-name">Паспортные данные</strong>

        <?php $form = ActiveForm::begin([
            'action' => ['edit-client-info/passport-save'],
            'id' => 'passport-info-form',
            'options' => [
                'class' => 'justify-content-center info-form ajax-form'
            ],
            'method' => 'post'
        ]); ?>

        <?= $form->field($passportInfoForm, 'serie')->textInput() ?>

        <?= $form->field($passportInfoForm, 'number')->textInput() ?>

        <?= $form->field($passportInfoForm, 'issueDate')->textInput(['type' => 'date']) ?>

        <?= $form->field($passportInfoForm, 'issueOrganization')->textInput() ?>

        <?= $form->field($passportInfoForm, 'organizationCode')->textInput() ?>

        <div class="submit-wrap">
            <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?php
    $this->registerJsFile(
        '@web/js/edit-info.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );
    ?>
</div>