<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Station :: Index</h1>
    </div>

    <div class="panel-body">
        <p>Some info about stations.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Updater station list', ['/station/index/index', 'returnUrl' => '/station/index/index'], ['class' => 'btn btn-primary']); ?>
    </div>
</div>