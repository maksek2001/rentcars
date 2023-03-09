<?php

namespace common\models\shop;

/**
 * Аренда
 * 
 * @property int $id
 * @property int $car_id
 * @property int $client_id
 * @property string $start_datetime
 * @property string $end_datetime
 * @property float $total_price
 * @property int $child_safety_seat_count
 * @property string $status
 * @property string $created_at
 * 
 */
class Rent extends \yii\db\ActiveRecord
{
    /**
     * Время ожидания в часах (время для завершения аренды)
     * Если за это время администратор не отметит успешное завершение аренды, то она будет считаться просроченной
     */
    public const WAITING_TIME = 72;

    public const DATETIME_DB_FORMAT = "Y-m-d H:i:s";

    public const STATUS_ACTIVE = 'active';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_OVERDUE = 'overdue';
    public const STATUS_PENDING = 'pending';

    public const STATUSES_MESSAGES = [
        self::STATUS_ACTIVE => [
            'status' => 'Активна',
            'client_message' => 'Ваша аренда активна. Если вы хотите её отменить, то нажмите на ссылку "Отменить аренду"',
            'admin_message' => 'Данная аренда активна. Для её завершения нажмите на ссылку "Завершить аренду"'
        ],
        self::STATUS_CANCELED => [
            'status' => 'Отменена',
            'client_message' => 'Вы самостоятельно отменили данную аренду',
            'admin_message' => 'Клиент самостоятельно отменил данную аренду'
        ],
        self::STATUS_COMPLETED => [
            'status' => 'Завершена',
            'client_message' => 'Данная аренда была успешно завершена',
            'admin_message' => 'Данная аренда была успешно завершена'
        ],
        self::STATUS_OVERDUE => [
            'status' => 'Просрочена',
            'client_message' => 'Вы не пришли за машиной в назначенное время',
            'admin_message' => 'Клиент не пришёл за машиной в назначенное время'
        ],
        self::STATUS_PENDING => [
            'status' => 'В ожидании',
            'client_message' => 'Ждём подтверждения завершения от администратора',
            'admin_message' => 'В ожидании завершения. Для её завершения нажмите на ссылку "Завершить аренду"'
        ]
    ];

    public static function tableName()
    {
        return '{{rents}}';
    }

    public static function findAllActiveRentsForCarByPeriod(string $startDatetime, string $endDatetime, int $carId): array
    {
        $sql = "SELECT r.*, c.email, c.id client_id 
                FROM rents r, clients c
                WHERE (
                    :start_datetime BETWEEN r.start_datetime AND r.end_datetime
                    OR :end_datetime BETWEEN r.start_datetime AND r.end_datetime
                    OR r.start_datetime BETWEEN :start_datetime AND :end_datetime
                    OR r.end_datetime BETWEEN :start_datetime AND :end_datetime)
                    AND r.car_id = :car_id AND r.status = :status
                    AND c.id = r.client_id";

        return static::findBySql($sql, [
            ':start_datetime' => $startDatetime,
            ':end_datetime' => $endDatetime,
            ':car_id' => $carId,
            ':status' => Rent::STATUS_ACTIVE
        ])->asArray()->all();
    }

    public static function findByFilters(string $status = '', string $startDatetime = '', string $endDatetime = '', ?float $minPrice = null, ?float $maxPrice = null): array
    {
        $sql = "SELECT 
                    r.*,
                    clients.email client_email,
                    clients.phone client_phone,
                    clients.fullname client_fullname,
                    clients.birth_date client_birth_date,
                    cars.name car_name,
                    cars.image car_image,
                    pi.serie passport_serie,
                    pi.number passport_number,
                    pi.issue_date passport_issue_date, 
                    pi.issue_organization passport_issue_organization,
                    pi.organization_code passport_organization_code,
                    dl.serie license_serie,
                    dl.number license_number,
                    dl.issue_date license_issue_date, 
                    dl.expiration_date license_expiration_date
                FROM rents r
                INNER JOIN clients
                    ON r.client_id = clients.id
                INNER JOIN cars
                    ON r.car_id = cars.id
                LEFT JOIN passports_info pi
                    ON r.client_id = pi.client_id
                LEFT JOIN driving_licenses dl
                    ON r.client_id = dl.client_id";

        $condition = '';

        if ($status !== '')
            $condition .= "r.status = '$status'";

        if ($startDatetime !== '' && $endDatetime !== '') {
            if ($condition)
                $condition .= ' AND ';

            $condition .= "(r.start_datetime BETWEEN '$startDatetime' AND '$endDatetime' ";
            $condition .= "OR r.end_datetime BETWEEN '$startDatetime' AND '$endDatetime' ";
            $condition .= "OR '$startDatetime' BETWEEN r.start_datetime AND r.end_datetime ";
            $condition .= "OR '$endDatetime' BETWEEN r.start_datetime AND r.end_datetime) ";
        }

        if ($minPrice != null && $maxPrice != null) {
            if ($condition)
                $condition .= ' AND ';

            $condition .= "r.total_price BETWEEN $minPrice AND $maxPrice";
        }

        if ($condition)
            return static::findBySql($sql . ' WHERE ' . $condition)->asArray()->all();

        return static::findBySql($sql)->asArray()->all();
    }
}
