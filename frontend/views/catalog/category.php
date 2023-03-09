<?php

use yii\bootstrap5\LinkPager;

$this->title = Yii::$app->name;
?>
<div class="catalog-container">
    <?php if ($cars != null) : ?>
        <?php foreach ($cars as $car) : ?>
            <?= $this->render('carBlock.php', ['car' => $car]) ?>
        <?php endforeach; ?>
        <nav>
            <?= LinkPager::widget([
                'pagination' => $pagination,

                'options' => [
                    'class' => 'pagination justify-content-center',
                ],
                'pageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item next',
                'prevPageCssClass' => 'page-item prev',
            ]) ?>
        </nav>
    <?php else : ?>
        <div class="alert alert-warning">
            Данный раздел пуст
        </div>
    <?php endif; ?>
</div>