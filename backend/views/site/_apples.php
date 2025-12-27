<?php

use backend\models\entities\AppleEntity;
use yii\bootstrap5\Html;

/** @var AppleEntity[] $appleEntities */
/** @var int $now */
?>

<?php foreach ($appleEntities as $apple): ?>
    <div class="col-md-3 mt-2 d-flex">
        <div class="card border-<?= $apple->color()->alias()?> w-100 h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <h5 class="card-title mb-1 text-<?= $apple->color()->alias()?>">
                            <i class="bi bi-apple"></i>
                            Яблоко #<?= $apple->id()?>
                        </h5>
                        <div class="small text-muted"><strong>Появилось:</strong> <?= (new DateTime())->setTimestamp($apple->appearedAt())->format('d.m H:i')?></div>
                        <?php if ($apple->fellAt()): ?>
                            <div class="small text-muted"><strong>Упало:</strong> <?= (new DateTime())->setTimestamp($apple->fellAt())->format('d.m H:i')?></div>
                        <?php endif; ?>
                    </div>

                    <div class="text-end">
                        <span class="badge text-bg-light"><small><?= $apple->status()->label()?></small></span>
                        <?php if ($apple->isEaten()): ?>
                            <span class="badge text-bg-light"><small>Съедено</small></span>
                        <?php elseif ($apple->isRotten()): ?>
                            <span class="badge text-bg-light"><small>Сгнило</small></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <div class="progress" role="progressbar" aria-label="Осталось" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: <?= $apple->sizePercent()?>%"><?= $apple->sizePercent()?></div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <?= Html::a('Упасть', ['site/fall-to-ground', 'id' => $apple->id()], [
                        'class' => 'btn btn-outline-warning',
                        'data-method' => 'post',
                    ]) ?>

                    <?= Html::beginForm(['site/eat', 'id' => $apple->id()]); ?>
                        <div class="input-group">
                            <span class="input-group-text">Съесть</span>
                            <?= Html::input('number', 'percent', 25, [
                                'class' => 'form-control',
                                'placeholder' => '%',
                                'min' => 1,
                                'max' => 100,
                                'required' => true,
                            ]) ?>
                            <?= Html::submitButton('OK', ['class' => 'btn btn-outline-primary']) ?>
                        </div>
                    <?= Html::endForm(); ?>

                    <?= Html::a('Удалить', ['site/delete', 'id' => $apple->id()], [
                        'class' => 'btn btn-outline-danger',
                        'data-method' => 'post',
                        'data-confirm' => 'Удалить яблоко?',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
