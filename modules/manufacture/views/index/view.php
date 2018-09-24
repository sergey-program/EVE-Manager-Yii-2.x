<?php

/**
 * @var app\components\ViewExtended               $this
 * @var \app\modules\manufacture\components\MItem $mItem
 */

?>

<div class="row">

    <div class="col-md-6 col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-right">
                    <img src="https://image.eveonline.com/Type/<?= $mItem->getBlueprint()->invType->typeID; ?>_32.png"
                         title="<?= $mItem->getBlueprint()->getInvType()->typeName; ?>"
                         class="img-thumbnail"
                         style="margin-left: 10px; margin-right: 10px;">
                </div>

                <h3 class="box-title">
                    <img src="https://image.eveonline.com/Type/<?= $mItem->getInvType()->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                    <?= $mItem->getInvType()->typeName; ?> (<?= $mItem->getInvType()->typeID; ?>)
                </h3>
            </div>

            <div class="box-body">
                <?php foreach ($mItem->getBlueprint()->getItems() as $cItem): ?>
                    <?= $this->render('_row', ['cItem' => $cItem, 'p' => 0]); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
