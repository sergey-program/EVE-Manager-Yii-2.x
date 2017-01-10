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
        <p>Some text below. Currently is empty. Last update date. Count of orders.</p>
    </div>

    <div class="panel-footer text-center">
        <?= Html::a('Update orders', ['order/update', 'characterID' => $this->getCharacter()->characterID], ['class' => 'btn btn-primary']); ?>
        <?= Html::a('Show list', ['order/list', 'characterID' => $this->getCharacter()->characterID], ['class' => 'btn btn-info']); ?>
    </div>
</div>