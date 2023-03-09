<?php

namespace backend\models\forms;

use Yii;
use common\models\shop\Car;
use yii\base\Model;
use backend\libs\storage\Storage;
use backend\libs\storage\classes\StorageFile;

class CarForm extends Model
{
    public const IMAGE_ADMISSIBLE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'jfif', 'webp', 'svg'];

    /** @var string */
    public $name;

    /** @var int */
    public $yearOfRelease;

    /** @var int */
    public $rentalPrice;

    /** @var int */
    public $power;

    /** @var int */
    public $placesCount;

    /** @var string */
    public $drive;

    /** @var string */
    public $transmission;

    /** @var bool */
    public $isPopular;

    public $image;

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'yearOfRelease' => 'Год выпуска',
            'rentalPrice' => 'Почасовая стоимость',
            'power' => 'Мощность (л.с.)',
            'placesCount' => 'Количество мест (включая водительское место)',
            'drive' => 'Привод',
            'transmission' => 'КПП',
            'isPopular' => 'Популярный',
            'image' => 'Изображение'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'yearOfRelease', 'rentalPrice', 'power', 'placesCount', 'drive', 'transmission'], 'required', 'message' => 'Обязательное поле!'],
            [['image', 'isPopular'], 'safe'],

            ['yearOfRelease', 'validateYearOfRelease']
        ];
    }

    public function validateYearOfRelease($attribute)
    {
        $currentYear = (int) date('Y');
        if ($this->yearOfRelease > $currentYear)
            $this->addError($attribute, 'Год выпуска не можеть быть больше текущего года');
    }

    public function save(?Car $car, ?int $objectiveId, $image): array
    {
        if (!$this->validate())
            return [
                'success' => false,
                'message' => 'Не удалось сохранить категорию'
            ];

        if ($image != null && $image->extension != '' && !in_array($image->extension, self::IMAGE_ADMISSIBLE_EXTENSIONS))
            return [
                'success' => false,
                'message' => 'Недопустимый формат изображения'
            ];

        if (!$car && Car::find()->where(['name' => $this->name])->count() > 0)
            return [
                'success' => false,
                'message' => 'Автомобиль с таким названием уже существует'
            ];

        if ($car == null) {
            $car = new Car();
            $car->objective_id = $objectiveId;
        }

        $car->name = $this->name;
        $car->year_of_release = $this->yearOfRelease;
        $car->rental_price = $this->rentalPrice;
        $car->power = $this->power;
        $car->places_count = $this->placesCount;
        $car->drive = $this->drive;
        $car->transmission = $this->transmission;

        if ($this->isPopular) {
            $car->is_popular = $this->isPopular;
        } else {
            $car->is_popular = false;
        }

        if ($image->extension != '') {
            $car->save();

            $storages = Yii::$app->params['storages'];
            $storage = new Storage($storages['cars']['directory']);

            if ($image->extension != '') {
                $car->image = 'image' . sprintf('%08d.%s', $car->id, $image->extension);
                $storageFile = new StorageFile($car->image, file_get_contents($image->tempName));

                if (!$storage->uploadFile($storageFile))
                    return [
                        'success' => false,
                        'message' => 'Не удалось загрузить изображение'
                    ];
            }
        }

        if ($car->image == null)
            return [
                'success' => false,
                'message' => 'Отсутствует изображение'
            ];

        if ($car->save())
            return [
                'success' => true,
                'message' => 'Автомобиль успешно сохранён'
            ];

        return [
            'success' => false,
            'message' => 'Не удалось сохранить автомобиль. Попробуйте ещё раз.'
        ];
    }
}
