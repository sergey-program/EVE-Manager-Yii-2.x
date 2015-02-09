<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Station index page</h1>
    </div>

    <div class="panel-body">
        <p>Some info about stations.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Updater station list', ['/station/index/index', 'updateStation' => 1], ['class' => 'btn btn-primary']); ?>
    </div>
</div>