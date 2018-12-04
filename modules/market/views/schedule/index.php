<?php

use yii\helpers\Url;

/**
 * @var app\components\ViewExtended       $this
 * @var \app\models\MarketPriceSchedule[] $marketPriceSchedules
 * @var \app\components\items\Item[]      $searchItems
 */

?>

<div class="row">
    <div class="col-md-6">

        <div class="panel box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Список обновляемых предметов:</h3>
            </div>

            <div class="box-body">
                <table class="table-bordered table table-hover">
                    <?php foreach ($marketPriceSchedules as $marketPriceSchedule): ?>
                        <tr>
                            <td>
                                <img src="https://image.eveonline.com/Type/<?= $marketPriceSchedule->typeID; ?>_32.png" class="img-thumbnail" style="margin-right: 10px;" alt="<?= $marketPriceSchedule->invType->typeName; ?>">
                                <?= $marketPriceSchedule->invType->typeName; ?>
                                <small class="text-muted"><?= $marketPriceSchedule->typeID; ?></small>
                            </td>

                            <td>
                                <?php $sellPrice = $marketPriceSchedule->invType->marketPrice ? $marketPriceSchedule->invType->marketPrice->sell : null; ?>
                                <?= \Yii::$app->formatter->asDecimal($sellPrice); ?>
                                <br/>

                                <?php $buyPrice = $marketPriceSchedule->invType->marketPrice ? $marketPriceSchedule->invType->marketPrice->buy : null; ?>
                                <?= \Yii::$app->formatter->asDecimal($buyPrice); ?>
                            </td>

                            <td class="text-right">
                                <?php if (Yii::$app->actionUpdatePrice->canUpdate($marketPriceSchedule->typeID)): ?>
                                    <a href="<?= Url::to(['update', 'typeID' => $marketPriceSchedule->typeID]); ?>" class="text-success" title="Manufal update">
                                        <i class="fa fa-fw fa-repeat"></i>
                                    </a>
                                <?php endif; ?>

                                <?php //$time = $group->marketUpdateGroup->timeUpdate ?? null; ?>
                                <small class="text-muted" style="margin-right: 10px; margin-left: 5px;" title="Last group update time">
                                    <?= \Yii::$app->formatter->asDatetime($marketPriceSchedule->timeUpdated, 'Y-MM-dd HH:mm:ss VV'); ?>
                                </small>

                                <a href="<?= Url::to(['index/delete', 'typeID' => $marketPriceSchedule->typeID]); ?>">
                                    <i class="fa fa-fw fa-remove text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel box box-primary">
            <div class="box-header">
                <h3 class="box-title">Добавить в список предмет:</h3>
            </div>

            <div class="box-body">
                <?= \yii\helpers\Html::beginForm(['index'], 'get', ['class' => 'form form-inline']); ?>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Строка или ID" name="searchString" value="<?= \Yii::$app->request->get('searchString', ''); ?>">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Найти предмет</button>
                </div>
                <?= \yii\helpers\Html::endForm(); ?>
            </div>
        </div>

        <?php if ($searchItems): ?>
            <div class="panel box box-primary">
                <div class="box-body">
                    <table class="table">
                        <?php foreach ($searchItems as $item): ?>
                            <tr>
                                <td>
                                    <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail" alt="<?= $item->typeName; ?>">
                                    <?= $item->typeName; ?>
                                    <small class="text-muted"><?= $item->typeID; ?> (<?= $item->getInvType()->groupID; ?>)</small>
                                    <?php if (true): ?>
                                        <a href="<?= Url::to(['schedule/add', 'typeID' => $item->typeID]); ?>">
                                            <i class="fa fa-fw fa-plus text-success"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
