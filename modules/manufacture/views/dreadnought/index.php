<?php

/**
 * @var app\components\ViewExtended  $this
 * @var \app\models\dump\InvTypes[]  $invTypes
 * @var \app\models\dump\InvGroups[] $groups
 */

?>

<div class="row">
    <?php foreach ($invTypes as $invType): ?>
        <div class="col-md-6 col-lg-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <img src="https://image.eveonline.com/Type/<?= $invType->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                        <?= $invType->typeName; ?> (<?= $invType->typeID; ?>)
                    </h3>
                </div>

                <div class="box-body">

                    <?php foreach ($invType->invTypeMaterials as $invTypeMaterial): ?>
                        <img src="https://image.eveonline.com/Type/<?= $invTypeMaterial->materialTypeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                        <?= $invTypeMaterial->materialInvType->typeName; ?> = <?= $invTypeMaterial->quantity; ?><br/>

                        <table class="table">
                            <?php foreach ($invTypeMaterial->materialInvType->invTypeMaterials as $invTypeMaterial2): ?>
                                <tr>
                                    <td>
                                        <img src="https://image.eveonline.com/Type/<?= $invTypeMaterial2->materialInvType->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                                        <?= $invTypeMaterial2->materialInvType->typeName; ?>
                                    </td>
                                    <td>
                                        <?= $invTypeMaterial2->quantity; ?> * <?= $invTypeMaterial->quantity; ?> = <?= number_format($invTypeMaterial2->quantity * $invTypeMaterial->quantity, 0, '.', ' '); ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
