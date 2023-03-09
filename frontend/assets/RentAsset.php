<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class RentAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/sweetalert2/sweetalert2.css',
        'css/scroll.css',
        'css/site.css',
        'css/rent.css'
    ];
    public $js = [
        'vendor/sweetalert2/sweetalert2.js',
        'js/popup.js',
        'js/main.js',
        'js/rent.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
