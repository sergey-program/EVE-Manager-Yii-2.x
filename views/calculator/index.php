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
    <div class="col-md-4">
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

    <div class="col-md-8">
        <?php if (!empty($items)): ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Result <?= count($items); ?>. <?= $formCalculator->filter; ?></h1>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Qty</td>
                            <td>Item</td>
                            <td>Price (unit)</td>
                            <td>Price (total)</td>
                        </tr>

                        <?php if ($formCalculator->filter): ?>
                            <?php foreach ($items['filter'] as $item): ?>
                                <?php /** @var Item $item */ ?>
                                <tr>
                                    <td><?= $item->quantity; ?></td>
                                    <td><?= $item->typeName; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach ($items['input'] as $item): ?>
                                <?php /** @var Item $item */ ?>
                                <tr>
                                    <td><?= $item->quantity; ?></td>
                                    <td><?= $item->typeName; ?></td>
                                    <td>
                                        <?= $item->getPriceBuy(); ?>
                                        <br/>
                                        <?= $item->getPriceSell(); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <p class="alert alert-info text-center">Empty input.</p>
        <?php endif; ?>
    </div>
</div>
