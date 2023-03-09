<?php

namespace frontend\controllers;

use frontend\models\forms\shop\RentForm;
use common\models\Client;
use common\models\Config;
use common\models\shop\Car;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\shop\Rent;
use yii;
use yii\helpers\Url;

class RentController extends SiteController
{
    public $layout = 'rent';

    public function actionIndex()
    {
        $carId = Yii::$app->request->get('carId');

        $car = Car::findOne($carId);

        if (!$car)
            throw new NotFoundHttpException();

        if (Yii::$app->user->isGuest)
            return $this->redirect(['authentication/login']);

        $client = Client::findOne(Yii::$app->user->id);

        if ($client->status == Client::STATUS_INACTIVE)
            return $this->redirect(['office/index']);

        $model = new RentForm();

        $model->carId = $car->id;
        $model->childSafetySeatCount = 0;

        if ($model->load(Yii::$app->request->post())) {

            $result = $model->addRent();

            if ($result['success']) {
                Yii::$app->session->setFlash('success', nl2br($result['message']));

                return $this->redirect(Url::to(['office/rents']));
            } else {
                Yii::$app->session->setFlash('error', nl2br($result['message']));
            }
        }

        $oldPrice = $car->rental_price;
        $newPrice = $car->rental_price;

        $discount = Config::find()->one()->discount_for_signup;
        if ($client == null || Rent::findAll(['client_id' => $client->id]) == null) {
            $model->rentalPrice = $car->rental_price * (1 - $discount);
            $newPrice = $model->rentalPrice;
        } else {
            $model->rentalPrice = $car->rental_price;
        }

        return $this->render('index', [
            'model' => $model,
            'car' => $car,
            'oldPrice' => $oldPrice,
            'newPrice' => $newPrice,
            'hasDiscount' => $oldPrice != $newPrice,
            'discount' => $discount
        ]);
    }

    public function actionValidateRent()
    {
        $model = new RentForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}
