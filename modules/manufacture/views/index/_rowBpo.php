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
            <?= $cItem->getBlueprint()->getInvType()->typeName; ?> x<?=$cItem->getBlueprint()->getRuns();?>
        </td>

        <td>
            ME: <?= $cItem->getBlueprint()->getMe(); ?>
            <input class="form-control" type="number" style="width: 55px;" min="0" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[me]" placeholder="10">
        </td>

        <td>
            TE: <?= $cItem->getBlueprint()->getTe(); ?>
            <input class="form-control" type="number" style="width: 55px;" min="0" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[te]" placeholder="10">
        </td>

        <td>
            ME Hull: <?= $cItem->getBlueprint()->getMeHull(); ?>
            <input class="form-control" type="number" style="width: 65px;" min="0" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[meHull]" placeholder="3">
        </td>
        <td>
            TE Hull
            <input class="form-control" type="number" style="width: 65px;" min="0" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[teHull]" placeholder="0">
        </td>

        <td>
            ME Rig
            <input class="form-control" type="number" style="width: 65px;" min="0" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[meRig]" placeholder="4.2">
        </td>

        <td>
            TE Rig
            <input class="form-control" type="number" style="width: 65px;" min="0" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[teRig]" placeholder="42">
        </td>

        <td>
            Price pre run: <?= $cItem->getBlueprint()->getRunPrice(); ?>
            <input class="form-control" type="number" style="width: 165px;" min="0" name="<?= $cItem->getBlueprint()->getInvType()->typeID; ?>[runPrice]" placeholder="Price per run">
        </td>
    </tr>

    <?php foreach ($cItem->getBlueprint()->getItems() as $item): ?>
        <?php if ($item->hasBlueprint()): ?>
            <?= $this->render('_rowBpo', ['cItem' => $item, 'p' => $p + 20]); ?>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>

