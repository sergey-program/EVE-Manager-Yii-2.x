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
        <p>In a future some info about api keys.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Add new Api', ['index/add'], ['class' => 'btn btn-primary']); ?>
    </div>
</div>