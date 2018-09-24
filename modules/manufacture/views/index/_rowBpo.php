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
                <div class="col-md-12">
                    <img src="https://image.eveonline.com/Type/<?= $cItem->getBlueprint()->getInvType()->typeID; ?>_32.png"
                         title="<?= $cItem->getBlueprint()->getInvType()->typeName; ?>"
                         class="img-thumbnail"
                         style="margin-left: 10px; margin-right: 10px;">

                    ME: <?= $cItem->getBlueprint()->getMe(); ?>
                    TE: <?= $cItem->getBlueprint()->getTe(); ?>

                    <input name="me_<?= $cItem->getBlueprint()->getInvType()->typeID; ?>">
                    <input name="te_<?= $cItem->getBlueprint()->getInvType()->typeID; ?>">
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

