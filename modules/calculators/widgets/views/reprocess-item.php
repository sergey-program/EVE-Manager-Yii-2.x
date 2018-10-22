<?php

/**
 * @var app\components\ViewExtended $this
 * @var \app\components\items\Item  $item
 */

?>

<div class="row" style="margin-bottom:5px;">
    <div class="col-md-2 text-center">
        <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
    </div>

    <div class="col-md-3">
        <?= $item->typeName; ?>
        <br/>
        <span class="text-muted"><?= $item->getQuantity(); ?> * <?= $item->getReprocessPercent(); ?>% = <?= $item->getReprocessQuantity(); ?></span>
    </div>

    <div class="col-md-1 text-right">
        <?= \Yii::$app->formatter->asInteger($item->getReprocessQuantity()); ?>
    </div>

    <div class="col-md-3 text-right">
        <span class="text-muted" title="Sell"><?= \Yii::$app->formatter->asDecimal($item->getPriceSell()); ?></span>
        <br/>
        <span class="text-muted" title="Buy"><?= \Yii::$app->formatter->asDecimal($item->getPriceBuy()); ?></span>
    </div>

    <div class="col-md-3 text-right">
        <?= \Yii::$app->formatter->asDecimal($item->getPriceSell() * $item->getReprocessQuantity()); ?>
        <br/>
        <?= \Yii::$app->formatter->asDecimal($item->getPriceBuy() * $item->getReprocessQuantity()); ?>
    </div>
</div>