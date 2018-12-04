<?php

/**
 * @var \app\components\ViewExtended         $this
 * @var \app\components\items\ItemCollection $itemCollection
 * @var \app\forms\FormCalculator            $formCalculator
 */

// @todo add volume to table
?>

<div class="box box-success">
    <div class="box-header with-border">
        <?php /* <div class="pull-right"><?= '';// number_format($itemCollection->getVolume(), 2, '.', ' '); ?> m3</div> */ ?>
        <h3 class="box-title">Prices:</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table text-center">
            <tr>
                <td>Sell</td>
                <td><?= \Yii::$app->formatter->asDecimal($itemCollection->getPriceSell()); ?></td>

                <?php if ($formCalculator->percentPrice): ?>
                    <?php $percent = $itemCollection->getPriceSell() * ($formCalculator->percentPrice / 100); ?>

                    <td>+<?= $formCalculator->percentPrice; ?>% (<?= \Yii::$app->formatter->asDecimal($percent); ?>)</td>
                    <td><?= \Yii::$app->formatter->asDecimal($itemCollection->getPriceSell() + $percent); ?></td>
                <?php endif; ?>
            </tr>

            <tr>
                <td>Buy</td>
                <td><?= number_format($itemCollection->getPriceBuy(), 2, '.', ' '); ?></td>

                <?php if ($formCalculator->percentPrice): ?>
                    <?php $percent = $itemCollection->getPriceBuy() * ($formCalculator->percentPrice / 100); ?>

                    <td>-<?= $formCalculator->percentPrice; ?>% (<?= number_format($percent, 2, '.', ' '); ?>)</td>
                    <td><?= number_format($itemCollection->getPriceBuy() - $percent, 2, '.', ' '); ?></td>
                <?php endif; ?>
            </tr>
        </table>
    </div>
</div>
