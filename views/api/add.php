<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var app\components\ViewExtended $this
 * @var app\models\Api              $api
 */
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Add new api</h1>
            </div>

            <div class="panel-body">
                <?php $form = ActiveForm::begin(); ?>

                <div class="form-group">
                    <?= $form->field($api, 'keyID'); ?>
                    <?= $form->field($api, 'vCode'); ?>
                </div>
            </div>

            <div class="panel-footer text-center">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary']); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>