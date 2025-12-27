<?php

/** @var yii\web\View $this */
/** @var AppleEntity[] $appleEntities */

use backend\models\entities\AppleEntity;
use yii\helpers\Url;

$this->title = 'Тестовое Задание';
?>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Тестовое задание</h1>

        <p class="lead">Здесь можно сгенерировать яблоки и выполнить действия: упасть, съесть, удалить.</p>

        <p>
            <a class="btn btn-lg btn-success js-generate-apples" data-url="<?= Url::to(['site/generate-apples']) ?>">
                Сгенерировать яблоки
            </a>
        </p>
    </div>

    <div class="body-content">
        <div class="row js-apples-list">
            <?= $this->render('_apples', compact('appleEntities'));?>
        </div>
    </div>
</div>
