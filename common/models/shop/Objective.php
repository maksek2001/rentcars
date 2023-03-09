<?php

namespace common\models\shop;

/**
 * Подкатегория
 * 
 * @property int $id
 * @property int $category_id
 * @property string $name
 * 
 */
class Objective extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{objectives}}';
    }
}
