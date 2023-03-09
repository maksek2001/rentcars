<?php

use frontend\assets\OfficeAsset;
use common\widgets\Alert;
use yii\bootstrap5\Html;
use yii\helpers\Url;

OfficeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <?= $this->render('common/header.php') ?>

    <main role="main" class="flex-shrink-0">
        <div class="office-subheader">
            <li>
                <a class="<?= (Yii::$app->controller->action->id == 'index') ? 'active' : '' ?>" href="<?= Url::toRoute('office/index') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-medium bi bi-person-square" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z" />
                    </svg>
                    ЛИЧНЫЕ ДАННЫЕ
                </a>
            </li>
            <li>
                <a class="<?= (Yii::$app->controller->action->id == 'rents') ? 'active' : '' ?>" href="<?= Url::toRoute('office/rents') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-medium bi bi-bag-check" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                    </svg>
                    АРЕНДЫ
                </a>
            </li>
        </div>
        <div class="container-fluid">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <?= $this->render('common/footer.php') ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>