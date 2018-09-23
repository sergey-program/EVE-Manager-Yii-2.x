<?php

/**
 * @var \app\components\ViewExtended       $this
 * @var \app\components\eve\ItemCollection $itemCollection
 * @var \app\forms\FormCalculator          $formCalculator
 */
?>

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Prices:</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table text-center">
            <tr>
                <td>Sell</td>
                <td><?= number_format($itemCollection->getPrice(0), 2, '.', ' '); ?></td>

                <?php if ($formCalculator->percentPrice): ?>
                    <?php $percent = $itemCollection->getPrice(0) * ($formCalculator->percentPrice / 100); ?>

                    <td>+<?= $formCalculator->percentPrice; ?>% (<?= number_format($percent, 2, '.', ' '); ?>)</td>
                    <td><?= number_format($itemCollection->getPrice(0) + $percent, 2, '.', ' '); ?></td>
                <?php endif; ?>
            </tr>

            <tr>
                <td>Buy</td>
                <td><?= number_format($itemCollection->getPrice(1), 2, '.', ' '); ?></td>

                <?php if ($formCalculator->percentPrice): ?>
                    <?php $percent = $itemCollection->getPrice(1) * ($formCalculator->percentPrice / 100); ?>

                    <td>-<?= $formCalculator->percentPrice; ?>% (<?= number_format($percent, 2, '.', ' '); ?>)</td>
                    <td><?= number_format($itemCollection->getPrice(1) - $percent, 2, '.', ' '); ?></td>
                <?php endif; ?>
            </tr>
        </table>
    </div>
</div>
