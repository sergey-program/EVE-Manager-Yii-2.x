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

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">
                        <?= count($items); ?> item(s).
                        <?= $formCalculator->filter ? 'Applied filter "' . $formCalculator->filter . '".' : ''; ?>
                    </h1>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Quantity</td>
                            <td>Item</td>
                            <td>Price (unit)</td>
                            <td>Price (total)</td>
                        </tr>

                        <?php $showItems = $formCalculator->filter ? $items['filter'] : $items['input']; ?>

                        <?php foreach ($showItems as $item): ?>
                            <?php /** @var Item $item */ ?>
                            <tr>
                                <td style="line-height: 42px;" class="text-right"><?= number_format($item->quantity, 0, '.', ' '); ?></td>
                                <td>
                                    <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail pull-left" style="margin-right: 10px;">
                                    <div>
                                        <?= $item->typeName; ?>
                                        <br/>
                                        <small class="text-muted"><?= $item->typeID; ?></small>
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
