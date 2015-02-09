<?php use yii\grid\GridView; ?>
<?php use yii\widgets\Pjax; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Station :: List</h1>
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'filterModel' => $mSearchConquerableStation,
            'dataProvider' => $mSearchConquerableStation->search(Yii::$app->getRequest()->get()),
            'columns' => [
                ['attribute' => 'stationID', 'label' => 'Station ID'],
                ['attribute' => 'stationName', 'label' => 'Station Name'],
                ['attribute' => 'solarSystemID', 'label' => 'Solar System ID']
            ]
        ]); ?>

        <?php Pjax::end(); ?>
    </div>

    <div class="panel-footer"></div>
</div>