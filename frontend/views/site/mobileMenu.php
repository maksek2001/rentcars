<?php

use yii\helpers\Html;
use yii\helpers\Url;

$title = Yii::$app->name;
?>
<div class="mobile-menu">
    <nav>
        <ul class="topmenu-mobile">
            <?php if (isset($menu)) foreach ($menu->categories as $category) : ?>
                <li>
                    <p>
                        <a href="<?= Url::toRoute(['catalog/category', 'id' => $category->id]) ?>">
                            <?php if ($category->icon) : ?>
                                <img src="/images/categories/icons/<?= Html::encode($category->icon) ?>" class='menu-icon'>
                            <?php else : ?>
                                <img src="/images/categories/icons/default.png" class='menu-icon'>
                            <?php endif; ?>
                            <?= Html::encode($category->name) ?>
                        </a>
                    </p>
                    <ul class="submenu-mobile">
                        <?php if (isset($menu->objectives[$category->id])) foreach ($menu->objectives[$category->id] as $objective) : ?>
                            <li>
                                <a href="<?= Url::toRoute(['catalog/objective', 'id' => $objective->id]) ?>" class="menu-a">
                                    <img src="/images/categories/icons/default.png" class='menu-icon'>
                                    <p class='action'>
                                        <?= Html::encode($objective->name) ?>
                                    </p>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <br>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>