<?php

use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var app\components\ViewExtended         $this
 * @var app\models\SearchConquerableStation $searchConquerableStation
 */
?>

<div class="row">
    <div class="col-md-12">

        <p class="text-center">
            <a href="<?= Url::to(['stations/update']); ?>" class="btn btn-primary">Update stations</a>
        </p>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">Stations</h1>
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

    </div>
</div>