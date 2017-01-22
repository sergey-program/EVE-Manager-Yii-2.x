<?php

use app\components\eve\Item;
use app\forms\FormCalculator;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * @var \app\components\ViewExtended $this
 * @var \app\forms\FormCalculator    $formCalculator
 * @var array                        $items
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Copy past from EVE</h3>
            </div>

            <?php $form = ActiveForm::begin(); ?>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($formCalculator, 'input', ['enableLabel' => false, 'enableError' => false])->textarea(['rows' => 3]); ?>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-6">
                            <?= $form->field($formCalculator, 'percent', ['enableLabel' => false, 'enableError' => false])->textInput(['placeholder' => 'Discount percent']); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($formCalculator, 'filter', ['enableLabel' => false, 'enableError' => false])->dropDownList([
                                FormCalculator::FILTER_PI => 'Only PI (T0 and T1 reactions).'
                            ], ['prompt' => "Don't use filter."]); ?>
                        </div>

                        <div class="col-md-12 text-center">
                            <?= Html::submitButton('Calculate', ['class' => 'btn btn-primary']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="col-md-6">
        <?php if (!empty($items)): ?>
            <?php
            /** @var Item[] $showItems */
            $showItems = ($formCalculator->filter && isset($items['filter'])) ? $items['filter'] : $items['input'];
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">
                        <?= count($showItems); ?> item(s).
                        <?= $formCalculator->filter ? 'Applied filter "' . $formCalculator->filter . '".' : ''; ?>
                    </h1>
                </div>

                <div class="panel-body">
                    <?php
                    $price = ['buy' => 0, 'percentBuy' => 0, 'sell' => 0, 'percentSell' => 0];

                    foreach ($showItems as $item) {
                        $price['buy'] += $item->getPriceBuy($item->quantity);

                        $price['percentBuy'] += $item->getPriceBuy($item->quantity) * ($formCalculator->percent / 100);
                        $price['percentSell'] += $item->getPriceSell($item->quantity) * ($formCalculator->percent / 100);

                        $price['sell'] += $item->getPriceSell($item->quantity);
                    }
                    ?>

                    <div class="maring-15">
                        <table class="table text-right">
                            <tr>
                                <td title="Jita Sell Orders">JS <?= number_format($price['sell'], 2, '.', ' '); ?></td>

                                <td title="Percent">
                                    + <?= number_format($price['percentSell'], 2, '.', ' '); ?>
                                    <small class="text-muted"><?= $formCalculator->percent; ?>%</small>
                                </td>

                                <td title="Percent Sell"><?= number_format($price['sell'] + $price['percentSell'], 2, '.', ' '); ?></td>
                            </tr>

                            <tr>
                                <td title="Jita Buy Orders">JB <?= number_format($price['buy'], 2, '.', ' '); ?></td>

                                <td title="Percent">
                                    - <?= number_format($price['percentBuy'], 2, '.', ' '); ?>
                                    <small class="text-muted"><?= $formCalculator->percent; ?>%</small>
                                </td>
                                <td title="Percent Buy"><?= number_format($price['buy'] - $price['percentBuy'], 2, '.', ' '); ?></td>
                            </tr>
                        </table>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <td>Item</td>
                            <td>Price (unit)</td>
                            <td>Quantity</td>
                            <td>Price (total)</td>
                        </tr>

                        <?php foreach ($showItems as $item): ?>
                            <?php /** @var Item $item */ ?>
                            <tr>
                                <td>
                                    <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail pull-left" style="margin-right: 10px;">
                                    <div>
                                        <?= $item->typeName; ?>
                                        <br/>
                                        <small class="text-muted">typeID: <?= $item->typeID; ?></small>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <span class="text-success" title="Best sell price."><?= number_format($item->getPriceSell(), 2, '.', ' '); ?></span>
                                    <br/>
                                    <span class="text-danger" title="Best buy price."><?= number_format($item->getPriceBuy(), 2, '.', ' '); ?></span>
                                </td>

                                <td style="line-height: 42px;" class="text-right">
                                    x<?= number_format($item->quantity, 0, '.', ' '); ?>
                                </td>

                                <td class="text-right">
                                    <?= number_format($item->getPriceSell($item->quantity), 2, '.', ' '); ?>
                                    <br/>
                                    <?= number_format($item->getPriceBuy($item->quantity), 2, '.', ' '); ?>
                                </td>
                            </tr>

                            <?php if ($item->calculateReprocess()->reprocess): ?>
                                <tr>
                                    <td colspan="4">
                                        <table class="table">
                                            <?php foreach ($item->reprocess as $repItem): ?>
                                                <tr>
                                                    <td><img src="https://image.eveonline.com/Type/<?= $repItem->typeID; ?>_32.png" class="img-thumbnail pull-left" style="margin-right: 10px;"></td>
                                                    <td><?= $repItem->typeName; ?></td>
                                                    <td><?= $repItem->quantity; ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                        </table>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
