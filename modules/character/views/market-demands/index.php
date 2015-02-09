<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Market Demands</h1>
    </div>

    <div class="panel-body"></div>

    <div class="panel-footer text-center">
        <?= Html::a('Create demand', ['/character/market-demands/create', 'characterID' => $mCharacter->characterID], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Show List', ['/character/market-demands/list', 'characterID' => $mCharacter->characterID], ['class' => 'btn btn-info']); ?>
    </div>
</div>