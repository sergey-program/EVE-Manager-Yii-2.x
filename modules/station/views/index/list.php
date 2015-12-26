<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var app\components\ViewExtended                         $this
 * @var app\modules\station\models\SearchConquerableStation $searchConquerableStation
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">List</h1>
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'filterModel' => $searchConquerableStation,
            'dataProvider' => $searchConquerableStation->search(Yii::$app->request->get()),
            'columns' => [
                ['attribute' => 'stationID'],
                ['attribute' => 'stationName'],
                ['attribute' => 'solarSystemID']
            ]
        ]); ?>

        <?php Pjax::end(); ?>
    </div>

    <div class="panel-footer"></div>
</div>