<?php

/**
 * @var \app\modules\manufacture\components\MItem $cItem
 * @var int                                       $p
 */

?>

<?php if ($cItem->hasBlueprint()): ?>
    <div class="row" style="margin-bottom: 10px; margin-left: <?= $p; ?>px">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <?php $imageUrl = 'https://image.eveonline.com/Type/' . $cItem->getBlueprint()->getInvType()->typeID . '_32.png'; ?>
                    <img src="<?= $imageUrl; ?>" title="<?= $cItem->getBlueprint()->getInvType()->typeName; ?>" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">

                    ME: <?= $cItem->getBlueprint()->getMe(); ?>
                    TE: <?= $cItem->getBlueprint()->getTe(); ?>
                </div>

                <div class="col-md-3">
                    <input class="form-control" type="number" style="width: 55px;" min="0" max="10" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[me]" placeholder="ME">
                    <input class="form-control" type="number" style="width: 55px;" min="0" max="20" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[te]" placeholder="TE">
                </div>

                <div class="col-md-3">

                </div>
            </div>
        </div>

    </div>

    <?php foreach ($cItem->getBlueprint()->getItems() as $item): ?>
        <?php if ($item->hasBlueprint()): ?>
            <?= $this->render('_rowBpo', ['cItem' => $item, 'p' => $p + 20]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>

