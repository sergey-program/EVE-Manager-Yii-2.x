<?php

/**
 * @var app\components\ViewExtended  $this
 * @var \app\models\dump\InvTypes[]  $invTypes
 * @var \app\models\dump\InvGroups[] $groups
 */

/** @var \app\components\actions\ActionRefine $actionRefine */
$actionRefine = \Yii::$app->actionRefine;

?>

<div class="row">
    <div class="col-md-12">

        <?php foreach ($groups as $group): ?>
            <?php foreach ($group->getCompressedOre() as $invType): ?>
                <?php $item = $invType->getItem(); ?>
                <?php $collection = $actionRefine->runOne($item); ?>

                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail margin-r-5">
                                <a data-toggle="collapse" href="#collapse<?= $item->typeID; ?>"><h3 class="box-title"><?= $item->typeName; ?></h3></a>
                                <small class="text-muted"><?= $item->typeID; ?></small>
                            </div>

                            <div class="col-md-4">
                                <small title="<?= $item->typeName; ?> price.">
                                    S: <span class="text-success"><?= \Yii::$app->formatter->asDecimal($item->getPriceSell()); ?></span>
                                    B: <span class="text-danger"><?= \Yii::$app->formatter->asDecimal($item->getPriceBuy()); ?></span>
                                </small>
                                <br/>
                                <small title="Price as minerals.">
                                    S: <span class="text-success"><?= \Yii::$app->formatter->asDecimal($collection->getPriceSell()); ?></span>
                                    B: <span class="text-danger"><?= \Yii::$app->formatter->asDecimal($collection->getPriceBuy()); ?></span>
                                </small>
                            </div>

                            <div class="col-md-4 text-right">
                                <small class="text-muted" title="Last group update time">
                                    <?php $timeItem = $item->getMarketPrice() ? $item->getMarketPrice()->timeUpdate : null; ?>
                                    <?= \Yii::$app->formatter->asDatetime($timeItem, 'Y-MM-dd HH:mm:ss VV'); ?>
                                </small>
                                <br/>
                                <small class="text-muted" title="Last group update time">
                                    <?php
                                    $groupMineral = \app\models\MarketUpdateGroup::findOne(18); // minerals group
                                    $timeMineral = $groupMineral ? $groupMineral->timeUpdate : null;
                                    ?>
                                    <?= \Yii::$app->formatter->asDatetime($timeMineral, 'Y-MM-dd HH:mm:ss VV'); ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div id="collapse<?= $item->typeID; ?>" class="panel-collapse collapse">
                        <div class="box-body">
                            <table class="table table-bordered table-condensed table-striped">
                                <?php foreach ($collection->getItems() as $rItem): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= $rItem->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;">
                                            <?= \Yii::$app->formatter->asInteger($rItem->getQuantity()); ?>
                                            <?= $rItem->typeName; ?>
                                            <small class="text-muted"><?= $rItem->getTypeID(); ?></small>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-muted" title="Sell"><?= \Yii::$app->formatter->asDecimal($rItem->getPriceSell()); ?></span>
                                            <br/>
                                            <span class="text-muted" title="Buy"><?= \Yii::$app->formatter->asDecimal($rItem->getPriceBuy()); ?></span>
                                        </td>
                                        <td class="text-right">
                                            <?= \Yii::$app->formatter->asDecimal($rItem->getPriceSell() * $rItem->getQuantity()); ?>
                                            <br/>
                                            <?= \Yii::$app->formatter->asDecimal($rItem->getPriceBuy() * $rItem->getQuantity()); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td><?= $actionRefine->percent; ?>% used for refine.</td>
                                    <td></td>
                                    <td class="text-right">
                                        <span title="Материалы по Sell цене">S: <?= \Yii::$app->formatter->asDecimal($collection->getPriceSell()); ?></span>
                                        <br/>
                                        <span title="Материалы по Buy цене">B: <?= \Yii::$app->formatter->asDecimal($collection->getPriceBuy()); ?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endforeach; ?>

    </div>
</div>
