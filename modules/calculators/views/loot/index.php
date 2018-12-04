<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * @var \app\components\ViewExtended $this
 * @var \app\forms\FormCalculator    $formCalculator
 */

?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-right"><a href="<?= Url::to(['update-prices']); ?>">Update prices</a></div>

                <h3 class="box-title">Input:</h3>
            </div>

            <?php $form = ActiveForm::begin(); ?>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($formCalculator, 'input', ['enableLabel' => false, 'enableError' => false])->textarea(['rows' => 3]); ?>
                        <p class="text-center text-sm text-muted">First column is name, second is quantity, all other columns does not matter (can be any).</p>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-6">
                            <?= $form->field($formCalculator, 'percentPrice', ['enableLabel' => false, 'enableError' => false])->textInput(['placeholder' => 'Discount percent']); ?>
                        </div>

                        <div class="col-md-6 text-center">
                            <?= $form->field($formCalculator, 'percentReprocess', ['enableLabel' => false, 'enableError' => false])->textInput(['placeholder' => 'Reprocess percent']); ?>
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

    <?php if (!empty($formCalculator->getItemCollection()->getItems())): ?>
        <div class="col-md-6">
            <?= $this->render('_boxPrices', [
                'itemCollection' => $formCalculator->getItemCollection(),
                'formCalculator' => $formCalculator
            ]); ?>

            <?= $this->render('_boxItems', ['items' => $formCalculator->getItemCollection()->getItems()]); ?>
        </div>

        <?php $collection= \Yii::$app->actionReprocess->runCollection($formCalculator->getItemCollection()); ?>

        <div class="col-md-6">
            <?= $this->render('_boxPrices', [
                'itemCollection' =>  $collection,
                'formCalculator' => $formCalculator
            ]); ?>

            <?= $this->render('_boxItems', ['items' => $collection->getItems()]); ?>
        </div>

    <?php endif; ?>
</div>
