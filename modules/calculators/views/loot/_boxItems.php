<?php

/**
 * @var \app\components\ViewExtended $this
 * @var \app\components\items\Item[] $items
 */

?>

<div class="box box-default">
    <div class="box-header with-border">
        <?php /* <div class="pull-right"><?= '';// number_format($itemCollection->getVolume(), 2, '.', ' '); ?> m3</div> */ ?>
        <h3 class="box-title">Items:</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table">
            <?php foreach ($items as $item): ?>
                <tr>
                    <td rowspan="2" style="width: 64px;" class="text-center">
                        <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail">
                    </td>

                    <td colspan="3"><?= $item->typeName; ?></td>
                </tr>

                <tr>
                    <td>
                        <small class="text-muted">x</small> <?= \Yii::$app->formatter->asInteger($item->getQuantity()); ?>
                    </td>

                    <td class="text-right">
                        <span class="text-success" title="Sell"><?= \Yii::$app->formatter->asDecimal($item->getPriceSell()); ?></span>
                        <br/>
                        <span class="text-danger" title="Buy"><?= \Yii::$app->formatter->asDecimal($item->getPriceBuy()); ?></span>
                    </td>

                    <td class="text-right">
                        <?= \Yii::$app->formatter->asDecimal($item->getPriceTotalSell()); ?>
                        <br/>
                        <?= \Yii::$app->formatter->asDecimal($item->getPriceTotalBuy()); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>