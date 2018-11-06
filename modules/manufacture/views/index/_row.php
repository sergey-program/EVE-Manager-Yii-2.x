<?php

/**
 * @var \app\components\items\Item $mItem
 * @var int                        $p
 */


/** @var \app\components\actions\ActionManufacture $actionManufacture */
$actionManufacture = \Yii::$app->actionManufacture;

?>

<div class="row" style="margin-bottom: 5px; margin-left: <?= $p; ?>px;">
    <div class="col-md-6">
        <img src="<?= $mItem->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;" onclick="$('#<?= $mItem->typeID; ?>').toggle();">
        <?= $mItem->typeName; ?>
        <small class="text-muted"><?= $mItem->typeID; ?></small>
    </div>

    <div class="col-md-2 text-left" style="line-height: 41.33px;">
        <?= \Yii::$app->formatter->asInteger($mItem->getQuantity()); ?>
    </div>

    <div class="col-md-4 text-right">
        <?php if ($mItem->hasBlueprint()): ?>
            <?= $mItem->getBlueprint()->getSettings()->me; ?> / <?= $mItem->getBlueprint()->getSettings()->meHull; ?> / <?= $mItem->getBlueprint()->getSettings()->meRig; ?>

            <a href="<?= \yii\helpers\Url::to(['settings/update', 'typeID' => $mItem->typeID]); ?>">
                <img src="<?= $mItem->getBlueprint()->getImageSrc(); ?>" class="img-thumbnail" style="margin-left: 10px;">
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($mItem->hasBlueprint()): ?>
    <div id="<?= $mItem->typeID; ?>" style="display: none;">
        <?php foreach ($actionManufacture->calculate($mItem->getBlueprint(), $mItem->getQuantity())->getItems() as $nItem): ?>
            <?= $this->render('_row', ['mItem' => $nItem, 'p' => $p + 30]); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
