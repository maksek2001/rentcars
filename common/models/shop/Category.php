<?php

namespace common\models\shop;

/**
 * Категория
 * 
 * @property int $category_id
 * @property string $name
 * @property string $icon название файла с иконкой
 * @property string $image название файла с основным изображнием
 * 
 */
class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{categories}}';
    }

    public static function findHeadCategories(int $limit)
    {
        return static::find()
            ->limit($limit)
            ->all();
    }

    public static function findMinRentalPriceForCategory(int $categoryId)
    {
        $queryResult = static::find()
            ->select('MIN(cars.rental_price) as min_rental_price')
            ->from('cars')
            ->innerJoin('objectives', 'cars.objective_id = objectives.id')
            ->where(['objectives.category_id' => $categoryId])
            ->asArray()->all();

        return $queryResult[0]['min_rental_price'];
    }
}
