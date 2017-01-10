<?php

use yii\helpers\Html;

/**
 * @var app\components\ViewExtended $this
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right"><?= $this->getCharacter()->characterName; ?></div>
        <h1 class="panel-title">Index</h1>
    </div>

    <div class="panel-body">
        <p>Show here some important info about demands.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Create demand', ['demand/create', 'characterID' => $this->getCharacter()->characterID], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Show List', ['demand/list', 'characterID' => $this->getCharacter()->characterID], ['class' => 'btn btn-info']); ?>
    </div>
</div>