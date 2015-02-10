<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Prices :: Index</h1>
    </div>

    <div class="panel-body">
        <p>Here will be some info about dates of prices update.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Update prices', ['/prices/index/update'], ['class' => 'btn btn-primary']); ?>
    </div>
</div>