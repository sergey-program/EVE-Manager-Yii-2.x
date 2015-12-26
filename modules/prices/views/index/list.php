<?php

use app\models\Price;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var app\components\ViewExtended           $this
 * @var app\modules\prices\models\SearchPrice $searchPrice
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">List</h1>
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'filterModel' => $searchPrice,
            'dataProvider' => $searchPrice->search(\Yii::$app->request->get()),
            'columns' => [
                ['attribute' => 'typeID', 'label' => 'Type ID'],
                ['attribute' => 'typeName', 'value' => 'invTypes.typeName', 'label' => 'Type Name'],
                ['attribute' => 'average'],
                ['attribute' => 'min'],
                ['attribute' => 'max'],
                ['attribute' => 'type', 'filter' => [Price::TYPE_BUY => 'Buy', Price::TYPE_SELL => 'Sell']],
            ]
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>