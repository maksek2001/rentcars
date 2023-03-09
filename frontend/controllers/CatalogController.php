<?php

namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use frontend\dtos\CatalogMenu;
use common\models\shop\Car;
use common\models\shop\Category;
use yii\web\NotFoundHttpException;
use common\models\shop\Objective;
use yii\helpers\Url;

class CatalogController extends SiteController
{
    private $_maxElementsCount = 1;

    /** @var Menu */
    public $menu;

    public $layout = 'catalog';

    public function beforeAction($action)
    {
        $this->menu = new CatalogMenu();

        $this->menu->categories = Category::find()->all();

        foreach ($this->menu->categories as $category) {
            $this->menu->objectives[$category->id] = Objective::findAll(['category_id' => $category->id]);
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $firstObjective = Objective::find()->one();

        if (!$firstObjective)
            throw new NotFoundHttpException();

        return $this->redirect(Url::to(['catalog/objective', 'id' => $firstObjective->id]));
    }

    public function actionSearch()
    {
        $startDatetime = Yii::$app->request->get('startDatetime');
        $endDatetime = Yii::$app->request->get('startDatetime');

        $cars = Car::findAvailableCars($startDatetime, $endDatetime);

        $carsCount = $cars->count();
        $pagination = new Pagination(['totalCount' => $carsCount, 'pageSize' => $this->_maxElementsCount]);

        $cars = $cars->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('searchResult', [
            'cars' => $cars,
            'pagination' => $pagination,
            'carsCount' => $carsCount
        ]);
    }

    public function actionObjective($id)
    {
        if (!Objective::findOne($id))
            throw new NotFoundHttpException();

        $cars = Car::find()->where(['objective_id' => $id]);

        $pagination = new Pagination(['totalCount' => $cars->count(), 'pageSize' => $this->_maxElementsCount]);

        $cars = $cars->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('objective', [
            'cars' => $cars,
            'pagination' => $pagination
        ]);
    }

    public function actionCar($id)
    {
        $car = Car::findOne($id);

        if (!$car)
            throw new NotFoundHttpException();

        return $this->render('car', [
            'car' => $car
        ]);
    }

    public function actionCategory($id)
    {
        if (!Category::findOne($id))
            throw new NotFoundHttpException();

        $cars = Car::findCarsByCategoryId($id);

        $pagination = new Pagination(['totalCount' => $cars->count(), 'pageSize' => $this->_maxElementsCount]);

        $cars = $cars->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('category', [
            'cars' => $cars,
            'pagination' => $pagination
        ]);
    }
}
