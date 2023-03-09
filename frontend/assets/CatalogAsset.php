<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CatalogAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/scroll.css',
        'css/site.css',
        'css/menu.css',
        'css/catalog.css'
    ];
    public $js = [
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
