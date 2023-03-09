<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/sweetalert2/sweetalert2.css',
        'css/scroll.css',
        'css/site.css',
        'css/rents.css'
    ];
    public $js = [
        'vendor/sweetalert2/sweetalert2.js',
        'js/popup.js',
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
