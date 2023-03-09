<?php

namespace backend\controllers;

use backend\models\forms\ConfigForm;
use Yii;
use backend\dtos\RentDto;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\forms\LoginForm;
use common\models\shop\Rent;
use common\models\Client;
use common\models\Config;

class SiteController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->name = 'RentCars';

        return parent::beforeAction($action);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->login()) {
                $this->goBack();
            } else {
                Yii::$app->session->setFlash('error', 'Введён неверный логин или пароль!');
                return $this->redirect('login');
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $rents = Rent::findByFilters(Rent::STATUS_ACTIVE);
        $dtosArray = [];
        foreach ($rents as $rent) {
            $dtosArray[] = new RentDto($rent);
        }

        return $this->render('index', [
            'rents' => $dtosArray
        ]);
    }

    public function actionLoadRents()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $status = Yii::$app->request->get('status');
        $startDatetime = Yii::$app->request->get('startDatetime');
        $endDatetime = Yii::$app->request->get('endDatetime');
        $minPrice = (Yii::$app->request->get('minPrice') != '') ? (float)Yii::$app->request->get('minPrice') : null;
        $maxPrice = (Yii::$app->request->get('maxPrice') != '') ? (float)Yii::$app->request->get('maxPrice') : null;

        $rents = Rent::findByFilters($status, $startDatetime, $endDatetime, $minPrice, $maxPrice);
        $dtosArray = [];
        foreach ($rents as $rent) {
            $dtosArray[] = new RentDto($rent);
        }

        return $this->renderPartial('rents', [
            'rents' => $dtosArray
        ]);
    }

    public function actionConfig()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $config = Config::find()->one();

        $model = new ConfigForm();

        if ($config) {
            $model->discountForSignup = $config->discount_for_signup * 100;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save($config)) {
                Yii::$app->session->setFlash('success', 'Конфигурация сохранена');

                return $this->redirect('config');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить конфигурацию');
            }
        }

        return $this->render('config', [
            'model' => $model
        ]);
    }

    public function actionCompleteRent($id)
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $rent = Rent::findOne($id);

        if (!$rent)
            throw new NotFoundHttpException();

        $rent->status = Rent::STATUS_COMPLETED;

        $rent->save();

        $this->sendEmail($rent);

        return $this->redirect('index');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            if ($exception->statusCode == 404)
                return $this->render('error-404', ['exception' => $exception]);
            else
                return $this->render('error', ['exception' => $exception]);
        }
    }

    private function sendEmail(Rent $rent): bool
    {
        $client = Client::findOne($rent->client_id);
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'completedRent-html', 'text' => 'completedRent-html'],
                ['client' => $client]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
            ->setTo($client->email)
            ->setSubject("Аренда автомобиля $rent->id " . Yii::$app->name)
            ->send();
    }
}
