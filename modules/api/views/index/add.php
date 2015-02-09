<?php use yii\bootstrap\ActiveForm; ?>
<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Api :: Add</h1>
    </div>

    <div class="panel-body">
        <?php $oForm = ActiveForm::begin(); ?>

        <div class="form-group">
            <?= $oForm->field($mApi, 'keyID'); ?>
            <?= $oForm->field($mApi, 'vCode'); ?>
        </div>
    </div>

    <div class="panel-footer text-center">
        <?= Html::submitButton('Add', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>