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
        <p>Here will be some info about dates of prices update.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Update prices', ['index/update'], ['class' => 'btn btn-primary']); ?>
    </div>
</div>