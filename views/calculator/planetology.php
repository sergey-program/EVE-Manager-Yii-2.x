<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * @var \app\components\ViewExtended         $this
 * @var \app\forms\FormCalculatorPlanetology $formCalculatorPlanetology
 * @var array                                $items
 */
?>

<div class="row">
    <div class="col-md-12 text-center">
        <h1>Counter ONLY for planetology.</h1>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">copy past</h1>
            </div>

            <?php $form = ActiveForm::begin(); ?>

            <div class="panel-body">
                <?= $form->field($formCalculatorPlanetology, 'list', ['enableLabel' => false])->textarea(['rows' => 15]); ?>
            </div>

            <div class="panel-footer">
                <?= Html::submitButton(); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Result <?= count($items); ?></h1>
            </div>

            <div class="panel-body">
                <?php if (!empty($items)): ?>

                    <div>
                        <?php
                        $totalBuy = 0; // bot list
                        $totalSell = 0; // top list

                        foreach ($items as $item) {
                            $totalBuy += $item['buy'] * $item['count'];
                            $totalSell += $item['sell'] * $item['count'];
                        }
                        ?>

                        Sell price <strong><?= number_format($totalSell, 2, '.', ' '); ?></strong>,
                        Buy price <strong><?= number_format($totalBuy, 2, '.', ' '); ?></strong>
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
                                <td><?= $item['count']; ?></td>
                                <td>
                                    <img src="https://image.eveonline.com/Type/<?= $item['typeID']; ?>_32.png">
                                    <?= $item['typeName']; ?>
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
                            <tr></tr>
                        <?php endforeach; ?>
                    </table>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
