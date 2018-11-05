<?php

/**
 * @var app\components\ViewExtended $this
 * @var \app\models\dump\InvTypes[] $invTypes
 * @var \app\models\dump\InvGroups  $group
 */

?>

<div class="row">
    <div class="col-md-12">
        <?php foreach ($group->getCompressedIce() as $invType): ?>
            <?= \app\modules\calculators\widgets\RefinedItemWidget::widget(['item' => $invType->getItem()]); ?>
        <?php endforeach; ?>
    </div>
</div>
