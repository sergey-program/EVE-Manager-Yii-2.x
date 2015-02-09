<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Market orders index for single character</h1>
    </div>

    <div class="panel-body"></div>

    <div class="panel-footer text-center">
        <?= Html::a('Update orders', ['/character/market-orders/update', 'characterID' => $this->getFromUrl('characterID')], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Show list', ['/character/market-orders/list', 'characterID' => $this->getFromUrl('characterID')], ['class' => 'btn btn-info']); ?>
    </div>
</div>