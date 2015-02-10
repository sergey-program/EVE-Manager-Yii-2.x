<?php
use app\modules\prices\models\Price;
use yii\grid\GridView;

?>
<?php use yii\widgets\Pjax; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Prices :: List</h1>
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'filterModel' => $mSearchPrice,
            'dataProvider' => $mSearchPrice->search(Yii::$app->getRequest()->get()),
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

    <div class="panel-footer"></div>
</div>