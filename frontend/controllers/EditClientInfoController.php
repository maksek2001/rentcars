<?php

namespace frontend\controllers;

use yii\web\Response;
use yii\bootstrap5\ActiveForm;
use frontend\models\forms\office\ContactInfoForm;
use frontend\models\forms\office\ClientInfoForm;
use frontend\models\forms\office\PassportForm;
use frontend\models\forms\office\DrivingLicenseInfoForm;
use yii;

class EditClientInfoController extends SiteController
{
    public $layout = 'office';

    public function actionMainSave()
    {
        $model = new ClientInfoForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => $model->updateInfo()];
        }
    }

    public function actionValidateMain()
    {
        $model = new ClientInfoForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionContactSave()
    {
        $model = new ContactInfoForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->updateInfo();
        }
    }

    public function actionValidateContact()
    {
        $model = new ContactInfoForm();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionPassportSave()
    {
        $model = new PassportForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => $model->updateInfo()];
        }
    }

    public function actionLicenseSave()
    {
        $model = new DrivingLicenseInfoForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => $model->updateInfo()];
        }
    }
}
