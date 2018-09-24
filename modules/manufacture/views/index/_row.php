<?php

/**
 * @var \app\modules\manufacture\components\MItem $cItem
 * @var int                                       $p
 */

?>


<div class="row" style="margin-bottom: 10px; margin-left: <?= $p; ?>px">
    <div class="col-md-6">
        <img src="https://image.eveonline.com/Type/<?= $cItem->getInvType()->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
        <?= $cItem->getInvType()->typeName; ?> <span class="text-muted"><?= $cItem->getInvType()->typeID; ?></span>
    </div>

    <div class="col-md-2 text-right">
        <?= $cItem->getQuantity(); ?>
    </div>

    <div class="col-md-4 text-right">
        <?php if ($cItem->hasBlueprint()): ?>
            <img src="https://image.eveonline.com/Type/<?= $cItem->getBlueprint()->invType->typeID; ?>_32.png"
                 class="img-thumbnail"
                 style="margin-left: 10px; margin-right: 10px;"
                 title="<?= $cItem->getBlueprint()->invType->typeName; ?>"
                 onclick="$('#<?= $cItem->getInvType()->typeID; ?>').toggle();">
        <?php endif; ?>

    </div>
</div>

<?php if ($cItem->hasBlueprint()): ?>
    <div id="<?= $cItem->getInvType()->typeID; ?>" style="display: none;">
        <?php foreach ($cItem->getBlueprint()->getItems() as $nItem): ?>
            <?= $this->render('_row', ['cItem' => $nItem, 'p' => $p + 30]); ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
