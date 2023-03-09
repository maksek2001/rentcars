<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\bootstrap5\ActiveForm;
use common\models\Config;
use common\models\shop\Category;
use frontend\dtos\CatalogMenu;
use common\models\shop\Objective;
use frontend\models\forms\shop\SearchForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    public $layout = 'main';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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

    public function actionIndex()
    {
        $categories = Category::find()->all();
        $categoryPrices = [];

        foreach ($categories as $category) {
            $categoryPrices[$category->id] = Category::findMinRentalPriceForCategory($category->id);
        }

        $model = new SearchForm();
        if ($model->load(Yii::$app->request->post())) {
            $url = $model->search();
            if ($url) {
                $this->redirect($url);
            }
        }

        return $this->render('index', [
            'model' => $model,
            'categories' => Category::find()->all(),
            'categoryPrices' => $categoryPrices,
            'discount' => Config::find()->one()->discount_for_signup * 100
        ]);
    }

    public function actionValidateSearch()
    {
        $model = new SearchForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionMobileMenu()
    {
        $menu = new CatalogMenu();

        $menu->categories = Category::find()->all();

        foreach ($menu->categories as $category) {
            $menu->objectives[$category->id] = Objective::findAll(['category_id' => $category->id]);
        }

        return $this->render('mobileMenu', [
            'menu' => $menu
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
}
