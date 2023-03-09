<?php

namespace backend\models\forms;

use common\models\shop\Category;
use yii\base\Model;
use Yii;
use backend\libs\storage\Storage;
use backend\libs\storage\classes\StorageFile;

class CategoryForm extends Model
{
    public const ICON_ADMISSIBLE_EXTENSIONS = ['png', 'svg'];
    public const IMAGE_ADMISSIBLE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'jfif', 'webp', 'svg'];

    /** @var string */
    public $name;

    public $icon;

    public $image;

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'icon' => 'Иконка',
            'image' => 'Изображение'
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Обязательное поле!'],

            ['name', 'string', 'length' => [2, 15]],

            [['icon', 'image'], 'safe'],
        ];
    }

    public function save(?Category $category, $icon, $image): array
    {
        if (!$this->validate())
            return [
                'success' => false,
                'message' => 'Не удалось сохранить категорию'
            ];

        if ($icon != null && $icon->extension != '' && !in_array($icon->extension, self::ICON_ADMISSIBLE_EXTENSIONS))
            return [
                'success' => false,
                'message' => 'Недопустимый формат иконки'
            ];

        if ($image != null && $image->extension != '' && !in_array($image->extension, self::IMAGE_ADMISSIBLE_EXTENSIONS))
            return [
                'success' => false,
                'message' => 'Недопустимый формат изображения'
            ];

        if (!$category && Category::find()->where(['name' => $this->name])->count() > 0)
            return [
                'success' => false,
                'message' => 'Категория с таким уже существует'
            ];

        if ($category == null)
            $category = new Category();

        $category->name = $this->name;

        if ($icon->extension != '' || $image->extension != '') {
            $category->save();

            $storages = Yii::$app->params['storages'];
            $storage = new Storage($storages['categories']['directory']);

            if ($icon->extension != '') {
                $category->icon = 'icon' . sprintf('%08d.%s', $category->id, $icon->extension);
                $storageFile = new StorageFile('/icons/' . $category->icon, file_get_contents($icon->tempName));

                if (!$storage->uploadFile($storageFile))
                    return [
                        'success' => false,
                        'message' => 'Не удалось загрузить иконку'
                    ];
            }

            if ($image->extension != '') {
                $category->image = 'image' . sprintf('%08d.%s', $category->id, $image->extension);
                $storageFile = new StorageFile($category->image, file_get_contents($image->tempName));

                if (!$storage->uploadFile($storageFile))
                    return [
                        'success' => false,
                        'message' => 'Не удалось загрузить изображение'
                    ];
            }
        }

        if ($category->save())
            return [
                'success' => true,
                'message' => 'Категория успешно сохранена'
            ];

        return [
            'success' => false,
            'message' => 'Не удалось сохранить категорию. Попробуйте ещё раз.'
        ];
    }
}
