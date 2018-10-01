<?php

/**
 * @var \app\modules\manufacture\components\MItem $cItem
 * @var int                                       $p
 */

?>

<?php if ($cItem->hasBlueprint()): ?>
    <tr>
        <td>
            <?php $imageUrl = 'https://image.eveonline.com/Type/' . $cItem->getBlueprint()->getInvType()->typeID . '_32.png'; ?>
            <img src="<?= $imageUrl; ?>" title="<?= $cItem->getBlueprint()->getInvType()->typeName; ?>" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
            <?= $cItem->getBlueprint()->getInvType()->typeName; ?> x<?= $cItem->getBlueprint()->getRuns(); ?>
        </td>

        <td><input class="form-control" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[me]" placeholder="<?= $cItem->getBlueprint()->getME(); ?>"></td>
        <td><input class="form-control" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[te]" placeholder="<?= $cItem->getBlueprint()->getTE(); ?>"></td>
        <td><input class="form-control" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[meHull]" placeholder="<?= $cItem->getBlueprint()->getMeHull(); ?>"></td>
        <td><input class="form-control" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[teHull]" placeholder="<?= $cItem->getBlueprint()->getTeHull(); ?>"></td>
        <td><input class="form-control" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[meRig]" placeholder="<?= $cItem->getBlueprint()->getMeRig(); ?>"></td>
        <td><input class="form-control" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[teRig]" placeholder="<?= $cItem->getBlueprint()->getTeRig(); ?>"></td>
        <td><input class="form-control" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[runPrice]" placeholder="<?= number_format($cItem->getBlueprint()->getRunPrice(), 0, '.', ' '); ?>"></td>
    </tr>

    <?php foreach ($cItem->getBlueprint()->getItems() as $item): ?>
        <?php if ($item->hasBlueprint()): ?>
            <?= $this->render('_rowBpo', ['cItem' => $item, 'p' => $p + 20]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>

