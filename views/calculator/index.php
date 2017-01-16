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
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Copy past from EVE</h1>
            </div>

            <?php $form = ActiveForm::begin(); ?>

            <div class="panel-body">
                <?= $form->field($formCalculator, 'input', ['enableLabel' => false, 'enableError' => false])->textarea(['rows' => 15]); ?>
                <?= $form->field($formCalculator, 'percent')->textInput(['placeholder' => '15']); ?>
                <?= $form->field($formCalculator, 'filter')->dropDownList([
                    FormCalculator::FILTER_PI => 'Only PI (T0 and T1 reactions).'
                ], ['prompt' => "Don't use filter."]); ?>
            </div>

            <div class="panel-footer text-center">
                <?= Html::submitButton('Calculate', ['class' => 'btn btn-primary']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="col-md-9">
        <?php if (!empty($items)): ?>
            <?php
            /** @var Item[] $showItems */
            $showItems = $formCalculator->filter ? $items['filter'] : $items['input'];
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
                            <td>Quantity</td>
                            <td>Item</td>
                            <td>Price (unit)</td>
                            <td>Price (total)</td>
                        </tr>

                        <?php foreach ($showItems as $item): ?>
                            <?php /** @var Item $item */ ?>
                            <tr>
                                <td style="line-height: 42px;" class="text-right"><?= number_format($item->quantity, 0, '.', ' '); ?></td>
                                <td>
                                    <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail pull-left" style="margin-right: 10px;">
                                    <div>
                                        <?= $item->typeName; ?>
                                        <br/>
                                        <small class="text-muted">typeID: <?= $item->typeID; ?></small>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->getPriceBuy(), 2, '.', ' '); ?>
                                    <br/>
                                    <?= number_format($item->getPriceSell(), 2, '.', ' '); ?>
                                </td>

                                <td class="text-right">
                                    <?= number_format($item->getPriceBuy($item->quantity), 2, '.', ' '); ?>
                                    <br/>
                                    <?= number_format($item->getPriceSell($item->quantity), 2, '.', ' '); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <p class="alert alert-info text-center">Empty input.</p>
        <?php endif; ?>
    </div>

</div>
