<?php

namespace frontend\controllers;

class HelpController extends SiteController
{
    public $layout = 'help';

    public function actionIndex()
    {
        return $this->render('index');
    }
}
