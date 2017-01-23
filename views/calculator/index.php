<?php

use app\components\eve\ItemCollection;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * @var \app\components\ViewExtended $this
 * @var \app\forms\FormCalculator    $formCalculator
 * @var ItemCollection               $itemCollection
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

                        <div class="col-md-6 text-center">
                            <?= Html::submitButton('Calculate', ['class' => 'btn btn-primary']); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>


    <?php if ($itemCollection->getItems()): ?>
        <div class="col-md-7">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h1 class="box-title"><?= count($itemCollection->getItems()); ?> item(s).</h1>
                </div>

                <div class="box-body no-padding">
                    <?php /*
                    <?php
                    $price = ['buy' => 0, 'percentBuy' => 0, 'sell' => 0, 'percentSell' => 0];

                    foreach ($showItems as $item) {
                        $price['buy'] += $item->getPriceBuy($item->quantity);

                        $price['percentBuy'] += $item->getPriceBuy($item->quantity) * ($formCalculator->percent / 100);
                        $price['percentSell'] += $item->getPriceSell($item->quantity) * ($formCalculator->percent / 100);

                        $price['sell'] += $item->getPriceSell($item->quantity);
                    }
                    ?>


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
*/ ?>
                    <!-- ITEMS -->

                    <table class="table">
                        <tr>
                            <td>Item</td>
                            <td>Unit</td>
                            <td>Quantity</td>
                            <td>Total</td>
                        </tr>

                        <?php foreach ($itemCollection->getItems() as $item): ?>
                            <tr>
                                <td>
                                    <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail pull-left" style="margin-right: 10px;">
                                    <div>
                                        <?= $item->typeName; ?>
                                        <br/>
                                        <small class="text-muted">typeID: <?= $item->typeID; ?></small>
                                    </div>
                                </td>

                                <td style="line-height: 42px;" class="text-left">
                                    <small class="text-muted">x</small> <?= number_format($item->quantity, 0, '.', ' '); ?>
                                </td>

                                <td class="text-right">
                                    <span class="text-success" title="Best sell price."><?= number_format($item->getPriceSell(1), 2, '.', ' '); ?></span>
                                    <br/>
                                    <span class="text-danger" title="Best buy price."><?= number_format($item->getPriceBuy(1), 2, '.', ' '); ?></span>
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
        </div>
        <div class="col-md-5">

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Reprocess</h3>
                </div>

                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <td>Item</td>
                            <td>Quantity</td>
                        </tr>

                        <?php foreach ($itemCollection->getReprocess() as $item): ?>
                            <tr>
                                <td>
                                    <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail pull-left" style="margin-right: 10px;">
                                    <div>
                                        <?= $item->typeName; ?>
                                        <br/>
                                        <small class="text-muted">typeID: <?= $item->typeID; ?></small>
                                    </div>
                                </td>

                                <td style="line-height: 42px;" class="text-left">
                                    <small class="text-muted">x</small> <?= number_format($item->quantity, 0, '.', ' '); ?>
                                </td>

                                <td class="text-right">
                                    <span class="text-success" title="Best sell price."><?= number_format($item->getPriceSell(1), 2, '.', ' '); ?></span>
                                    <br/>
                                    <span class="text-danger" title="Best buy price."><?= number_format($item->getPriceBuy(1), 2, '.', ' '); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>


</div>
