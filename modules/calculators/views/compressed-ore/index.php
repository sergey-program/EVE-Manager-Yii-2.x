<?php

/**
 * @var app\components\ViewExtended  $this
 * @var \app\models\dump\InvTypes[]  $invTypes
 * @var \app\models\dump\InvGroups[] $groups
 */

?>

<div class="row">
    <div class="col-md-8">
        <?php foreach ($groups as $group): ?>
            <?php foreach ($group->getCompressedOre() as $invType): ?>
                <?= \app\modules\calculators\widgets\RefinedItemWidget::widget(['item' => $invType->getItem()]); ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>
