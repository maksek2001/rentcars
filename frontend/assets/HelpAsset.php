<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class HelpAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/scroll.css',
        'css/site.css',
        'css/help.css'
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
