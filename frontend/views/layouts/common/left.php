<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="shop-left">
    <nav>
        <ul class="topmenu">
            <?php
            if (isset($this->context->menu)) foreach ($this->context->menu->categories as $category) : ?>
                <li>
                    <p class="down">
                        <?php if ($category->icon) : ?>
                            <img src="/images/categories/icons/<?= $category->icon ?>" class='menu-icon'>
                        <?php else : ?>
                            <img src="/images/categories/icons/default.png" class='menu-icon'>
                        <?php endif; ?>
                        <?= Html::encode($category->name) ?>
                    </p>
                    <ul class="submenu">
                        <?php if (isset($this->context->menu->objectives[$category->id])) foreach ($this->context->menu->objectives[$category->id] as $objective) : ?>
                            <li>
                                <a class="menu-a <?= (Yii::$app->controller->action->id == 'objective' & Yii::$app->request->get('id') == $objective->id) ? 'active' : '' ?>" href="<?= Url::toRoute(['catalog/objective', 'id' => $objective->id]) ?>">
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