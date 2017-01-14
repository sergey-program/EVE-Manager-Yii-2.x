<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * @var \app\components\ViewExtended $this
 * @var \app\forms\FormCalculator    $formCalculator
 * @var array                        $items
 */
?>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Copy past from EVE</h1>
            </div>

            <?php $form = ActiveForm::begin(); ?>

            <div class="panel-body">
                <?= $form->field($formCalculator, 'list', ['enableLabel' => false])->textarea(['rows' => 15]); ?>
                <?= $form->field($formCalculator, 'percent')->textInput(['placeholder' => '15']); ?>
                <?= $form->field($formCalculator, 'onlyPI')->checkbox(); ?>
            </div>

            <div class="panel-footer text-center">
                <?= Html::submitButton('Calculate', ['class' => 'btn btn-primary']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="col-md-8">
        <?php if ($items): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Result <?= count($items); ?></h1>
                </div>

                <div class="panel-body">
                    <?php if (!empty($items)): ?>

                        <div class="col-md-6">
                            <?php
                            $totalBuy = 0; // bot list
                            $totalSell = 0; // top list

                            foreach ($items as $item) {
                                $totalBuy += $item['buy'] * $item['count'];
                                $totalSell += $item['sell'] * $item['count'];
                            }
                            ?>

                            Jita sell <strong><?= number_format($totalSell, 2, '.', ' '); ?></strong>
                            <br/>
                            Jita buy <strong><?= number_format($totalBuy, 2, '.', ' '); ?></strong>
                        </div>

                        <div class="col-md-6">
                            <?php if ($formCalculator->percent): ?>
                                <?php
                                $totalSellPercent = round($totalSell * ($formCalculator->percent / 100), 2);
                                $totalBuyPercent = round($totalBuy * ($formCalculator->percent / 100), 2);
                                ?>
                                Corp sell <strong><?= number_format($totalSell + $totalSellPercent, 2, '.', ' '); ?></strong>
                                (+<?= number_format($totalSellPercent, 2, '.', ' '); ?>)
                                <br/>
                                Corp price <strong><?= number_format($totalBuy - $totalBuyPercent, 2, '.', ' '); ?></strong>
                                (-<?= number_format($totalBuyPercent, 2, '.', ' '); ?>)
                            <?php endif; ?>
                        </div>


                        <table class="table table-bordered">
                            <tr>
                                <td>Qty</td>
                                <td>Item</td>
                                <td>Price (unit)</td>
                                <td>Price (total)</td>
                            </tr>

                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="text-right"><?= number_format($item['count'], 0, '.', ' '); ?></td>
                                    <td>
                                        <img src="https://image.eveonline.com/Type/<?= $item['typeID']; ?>_32.png" class="pull-right">

                                        <?= $item['typeName']; ?>
                                        <br/>
                                        <small class="text-muted">typeID: <?= $item['typeID']; ?></small>
                                    </td>

                                    <td class="text-right">
                                        <?= number_format($item['sell'], 2, '.', ' '); ?>
                                        <br/>
                                        <?= number_format($item['buy'], 2, '.', ' '); ?>
                                    </td>

                                    <td class="text-right">
                                        <?= number_format($item['sell'] * $item['count'], 2, '.', ' '); ?>
                                        <br/>
                                        <?= number_format($item['buy'] * $item['count'], 2, '.', ' '); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <p class="alert alert-info text-center">Empty input.</p>
        <?php endif; ?>
    </div>
</div>
