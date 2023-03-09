<?php

namespace common\models\shop;

/**
 * Модель автомобиля
 * 
 * @property int $id
 * @property string $name
 * @property int $year_of_release
 * @property int $rental_price
 * @property string $image
 * @property int $power
 * @property int $places_count
 * @property string $drive
 * @property string $transmission
 * @property bool $is_popular
 * 
 */
class Car extends \yii\db\ActiveRecord
{
    public const MECHANICAL_TRANSMISSION = 'mechanical';
    public const AUTOMATIC_TRANSMISSION = 'automatic';
    public const ROBOTIC_TRANSMISSION = 'robotic';
    public const VARIABLE_TRANSMISSION = 'variable';

    public const ALL_WHEEL_DRIVE = 'all';
    public const REAR_WHEEL_DRIVE = 'rear';
    public const FRONT_WHEEL_DRIVE = 'front';

    public const TRANSMISSION_TYPES = [
        self::MECHANICAL_TRANSMISSION => 'Механическая',
        self::AUTOMATIC_TRANSMISSION => 'Автоматическая',
        self::ROBOTIC_TRANSMISSION => 'Роботизированная',
        self::VARIABLE_TRANSMISSION => 'Вариативная'
    ];

    public const DRIVE_TYPES = [
        self::ALL_WHEEL_DRIVE => 'Полный',
        self::REAR_WHEEL_DRIVE => 'Задний',
        self::FRONT_WHEEL_DRIVE => 'Передний'
    ];

    public static function tableName()
    {
        return '{{cars}}';
    }

    public static function findCarsByCategoryId(int $categoryId)
    {
        return static::find()
            ->select('*')
            ->from('cars')
            ->innerJoin('objectives', 'cars.objective_id = objectives.id')
            ->where(['objectives.category_id' => $categoryId]);
    }
    public static function findAvailableCars(string $startDatetime, string $endDatetime)
    {
        $sql = "SELECT cars.*
                FROM cars
                WHERE NOT EXISTS (
                    SELECT 1 
                    FROM rents r
                    WHERE (
                        :start_datetime BETWEEN r.start_datetime AND r.end_datetime
                        OR :end_datetime BETWEEN r.start_datetime AND r.end_datetime
                        OR r.start_datetime BETWEEN :start_datetime AND :end_datetime
                        OR r.end_datetime BETWEEN :start_datetime AND :end_datetime)
                        AND r.status = :status AND cars.id = r.car_id)";

        return static::findBySql($sql, [
            ':start_datetime' => $startDatetime,
            ':end_datetime' => $endDatetime,
            ':status' => Rent::STATUS_ACTIVE
        ]);
    }
}
