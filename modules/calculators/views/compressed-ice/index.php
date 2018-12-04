<?php

use app\modules\calculators\widgets\RefinedItemWidget;

/**
 * @var app\components\ViewExtended  $this
 * @var \app\components\items\Item[] $items
 */

?>

<div class="row">
    <div class="col-md-8">
        <?php foreach ($items as $item): ?>
            <?= RefinedItemWidget::widget(['item' => $item]); ?>
        <?php endforeach; ?>
    </div>
</div>
