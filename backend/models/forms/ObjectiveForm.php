<?php

namespace backend\models\forms;

use common\models\shop\Objective;
use yii\base\Model;

class ObjectiveForm extends Model
{
    /** @var string */
    public $name;

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
        ];
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Обязательное поле!'],
            ['name', 'unique', 'targetClass' => '\common\models\shop\Objective', 'message' => 'Подкатегория с таким названием уже существует'],
        ];
    }

    public function save(?Objective $objective, ?int $categoryId): bool
    {
        if (!$this->validate())
            return false;

        if ($objective == null) {
            $objective = new Objective();
            $objective->category_id = $categoryId;
        }

        $objective->name = $this->name;

        return $objective->save();
    }
}
