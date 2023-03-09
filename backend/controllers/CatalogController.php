<?php

namespace backend\controllers;

use backend\dtos\Catalog;
use Yii;
use backend\models\forms\CategoryForm;
use common\models\shop\Objective;
use common\models\shop\Car;
use common\models\shop\Category;
use backend\libs\storage\Storage;
use backend\models\forms\CarForm;
use backend\models\forms\ObjectiveForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class CatalogController extends SiteController
{
    public $layout = 'catalog';

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $catalog = new Catalog();

        $catalog->categories = Category::find()->all();

        foreach ($catalog->categories as $category) {
            $catalog->objectives[$category->id] = Objective::findAll(['category_id' => $category->id]);
            foreach ($catalog->objectives[$category->id] as $objective) {
                $catalog->cars[$objective->id] = Car::findAll(['objective_id' => $objective->id]);
            }
        }

        return $this->render('index', [
            'catalog' => $catalog
        ]);
    }

    public function actionCategory()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $id = Yii::$app->request->get('id');

        $category = Category::findOne($id);

        $model = new CategoryForm();

        if ($category) {
            $model->name = $category->name;
        }

        if ($model->load(Yii::$app->request->post())) {
            $icon = UploadedFile::getInstance($model, 'icon');
            $image = UploadedFile::getInstance($model, 'image');
            $result =  $model->save($category, $icon, $image);
            if ($result['success']) {
                Yii::$app->session->setFlash('success', nl2br($result['message']));

                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', nl2br($result['message']));
            }
        }

        return $this->render('category', [
            'model' => $model,
            'category' => $category
        ]);
    }

    public function actionObjective()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $categoryId = Yii::$app->request->get('categoryId');

        $objectiveId = Yii::$app->request->get('objectiveId');
        $objective = Objective::findOne($objectiveId);

        if ($objective == null && $categoryId == null)
            throw new NotFoundHttpException();

        $model = new ObjectiveForm();

        if ($objective) {
            $model->name = $objective->name;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save($objective, $categoryId)) {
                Yii::$app->session->setFlash('success', 'Подкатегория успешно сохранена');

                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить подкатегорию');
            }
        }

        return $this->render('objective', [
            'model' => $model,
            'objective' => $objective
        ]);
    }

    public function actionCar()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $objectiveId = Yii::$app->request->get('objectiveId');

        $carId = Yii::$app->request->get('carId');
        $car = Car::findOne($carId);


        if ($car == null && $objectiveId == null)
            throw new NotFoundHttpException();

        $model = new CarForm();

        if ($car) {
            $model->name = $car->name;
            $model->yearOfRelease = $car->year_of_release;
            $model->rentalPrice = $car->rental_price;
            $model->power = $car->power;
            $model->placesCount = $car->places_count;
            $model->drive = $car->drive;
            $model->transmission = $car->transmission;
            $model->isPopular = $car->is_popular;
        }

        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'image');
            $result =  $model->save($car, $objectiveId, $image);
            if ($result['success']) {
                Yii::$app->session->setFlash('success', nl2br($result['message']));

                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', nl2br($result['message']));
            }
        }

        return $this->render('car', [
            'model' => $model,
            'car' => $car
        ]);
    }

    public function actionDeleteCategory($id)
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $category = Category::findOne($id);

        if (!$category)
            throw new NotFoundHttpException();

        $storages = Yii::$app->params['storages'];
        $storage = new Storage($storages['categories']['directory']);

        if ($category->icon)
            $storage->deleteFile('/icon/' . $category->icon);

        if ($category->image)
            $storage->deleteFile($category->image);

        if ($category->delete()) {
            Yii::$app->session->setFlash('success', 'Категория удалена');
        } else {
            Yii::$app->session->setFlash('success', 'Не удалось удалить категорию. Попробуйте ещё раз');
        }

        $this->redirect('index');
    }

    public function actionDeleteObjective($id)
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $objective = Objective::findOne($id);

        if (!$objective)
            throw new NotFoundHttpException();

        if ($objective->delete()) {
            Yii::$app->session->setFlash('success', 'Подкатегория удалена');
        } else {
            Yii::$app->session->setFlash('success', 'Не удалось удалить подкатегорию. Попробуйте ещё раз');
        }

        $this->redirect('index');
    }

    public function actionDeleteCar($id)
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $car = Car::findOne($id);

        if (!$car)
            throw new NotFoundHttpException();

        if ($car->delete()) {
            Yii::$app->session->setFlash('success', 'Автомобиль удалён');
        } else {
            Yii::$app->session->setFlash('success', 'Не удалось удалить автомобиль. Попробуйте ещё раз');
        }

        $this->redirect('index');
    }
}
