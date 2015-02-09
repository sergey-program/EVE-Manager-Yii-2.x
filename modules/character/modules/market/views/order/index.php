<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right"><?= $this->getController()->mCharacter->characterName; ?></div>
        <h1 class="panel-title">Orders :: Index</h1>
    </div>

    <div class="panel-body">
        <p>Some text below. Currently is empty. Last update date. Count of orders.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Update orders', ['/character/market/order/update', 'characterID' => $this->getController()->mCharacter->characterID], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Show list', ['/character/market/order/list', 'characterID' => $this->getController()->mCharacter->characterID], ['class' => 'btn btn-info']); ?>
    </div>
</div>