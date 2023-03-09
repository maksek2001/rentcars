<?php

namespace backend\models\forms;

use common\models\Config;
use yii\base\Model;

class ConfigForm extends Model
{
    /** @var float */
    public $discountForSignup;

    public function attributeLabels()
    {
        return [
            'discountForSignup' => 'Скидка за регистрацию в процентах'
        ];
    }

    public function rules()
    {
        return [
            ['discountForSignup', 'required', 'message' => 'Обязательное поле!']
        ];
    }

    public function save(?Config $config)
    {
        if (!$this->validate())
            return false;

        if ($config == null)
            $config = new Config();

        $config->discount_for_signup = $this->discountForSignup / 100;

        return $config->save();
    }
}
