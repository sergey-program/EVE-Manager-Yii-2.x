<?php

use yii\helpers\Html;

/**
 * @var app\components\ViewExtended $this
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Index</h1>
    </div>

    <div class="panel-body">
        <p>Some info about stations.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Updater station list', ['index/update'], ['class' => 'btn btn-primary']); ?>
    </div>
</div>