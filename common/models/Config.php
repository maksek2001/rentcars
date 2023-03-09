<?php

namespace common\models;

/**
 * Конфигурация сайта
 * 
 * @property int $id
 * @property float $discount_for_signup
 * 
 */
class Config extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{config}}';
    }
}
