<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right"><?= $this->getController()->mCharacter->characterName; ?></div>
        <h1 class="panel-title">Demands :: Index</h1>
    </div>

    <div class="panel-body">
        <p>Show here some important info about demands.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Create demand', ['/character/market/demand/create', 'characterID' => $this->getController()->mCharacter->characterID], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Show List', ['/character/market/demand/list', 'characterID' => $this->getController()->mCharacter->characterID], ['class' => 'btn btn-info']); ?>
    </div>
</div>