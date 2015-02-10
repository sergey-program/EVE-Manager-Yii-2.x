<?php use yii\helpers\Html; ?>
<?php use yii\bootstrap\ActiveForm; ?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Authentication</h1>
            </div>

            <div class="panel-body">
                <?php $oForm = ActiveForm::begin(); ?>

                <?= $oForm->field($fLogin, 'username') ?>
                <?= $oForm->field($fLogin, 'password')->passwordInput() ?>
                <?= $oForm->field($fLogin, 'rememberMe')->checkbox() ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-sm-offset-3 text-center">
        <p class="text-muted">This site is closed for public. If you want get access contact me buy mail.</p>
    </div>
</div>
