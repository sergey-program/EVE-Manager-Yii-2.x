<?php

/**
 * @var \app\components\ViewExtended $this
 * @var \app\components\items\Item[] $items
 */

// @todo add item volume in tables
?>

<?php if ($items): ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <?php /* <div class="pull-right"><?= '';// number_format($itemCollection->getVolume(), 2, '.', ' '); ?> m3</div> */ ?>
            <h3 class="box-title">Items:</h3>
        </div>

        <div class="box-body no-padding">
            <table class="table">
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail invType" alt="<?= $item->typeName; ?>">
                            <?= $item->typeName; ?>
                        </td>

                        <td><?= \Yii::$app->formatter->asInteger($item->getQuantity()); ?></td>

                        <td class="text-right">
                            <?= \Yii::$app->formatter->asDecimal($item->getPriceSell()); ?>
                            <br/>
                            <?= \Yii::$app->formatter->asDecimal($item->getPriceBuy()); ?>
                        </td>

                        <td class="text-right">
                            <?= \Yii::$app->formatter->asDecimal($item->getPriceTotalSell()); ?>
                            <br/>
                            <?= \Yii::$app->formatter->asDecimal($item->getPriceTotalBuy()); ?>
                        </td>
                        <td class="text-muted text-right">
                            <?= \Yii::$app->formatter->asRelativeTime($item->getMarketPrice()->timeUpdate ?? null); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endif; ?>
