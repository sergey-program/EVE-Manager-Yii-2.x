<?php

/**
 * @var \app\components\ViewExtended       $this
 * @var \app\components\eve\ItemCollection $itemCollection
 */
?>

<div class="box box-default">
    <div class="box-header with-border">
        <div class="pull-right"><?= number_format($itemCollection->getVolume(), 2, '.', ' '); ?> m3</div>
        <h3 class="box-title">Items:</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table">
            <?php foreach ($itemCollection->getItems() as $item): ?>
                <tr>
                    <td rowspan="2" style="width: 64px;" class="text-center">
                        <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail">
                    </td>

                    <td colspan="3">
                        <?= $item->typeName; ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <small class="text-muted">x</small> <?= number_format($item->quantity, 0, '.', ' '); ?>
                    </td>

                    <td class="text-right">
                        <span class="text-success" title="Best sell price.">
                            <?= number_format($item->getPriceSell(1), 2, '.', ' '); ?>
                        </span>

                        <br/>

                        <span class="text-danger" title="Best buy price.">
                            <?= number_format($item->getPriceBuy(1), 2, '.', ' '); ?>
                        </span>
                    </td>

                    <td class="text-right">
                        <?= number_format($item->getPriceSell(), 2, '.', ' '); ?>
                        <br/>
                        <?= number_format($item->getPriceBuy(), 2, '.', ' '); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>