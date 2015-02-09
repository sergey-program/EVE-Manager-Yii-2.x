<?php use app\models\api\character\MarketOrder; ?>
<?php use yii\grid\GridView; ?>
<?php use yii\widgets\Pjax; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Market Orders List</h1>
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'filterModel' => $mSearchMarketOrder,
            'dataProvider' => $mSearchMarketOrder->search(Yii::$app->getRequest()->get()),
            'columns' => [
                [
                    'format' => 'raw',
                    'value' => function ($mModel) {
                        return '<img class="img-thumbnail" src="https://image.eveonline.com/Type/' . $mModel->typeID . '_32.png">';
                    }
                ],
                ['attribute' => 'typeName', 'value' => 'invTypes.typeName', 'label' => 'Item'],
                ['attribute' => 'stationName', 'value' => 'staStation.stationName', 'label' => 'Station'],
                [
                    'attribute' => 'orderState',
                    'label' => 'Order State',
                    'filter' => [
                        MarketOrder::ORDER_STATE_OPEN => 'Open \ Active',
                        MarketOrder::ORDER_STATE_CLOSED => 'Closed',
                        MarketOrder::ORDER_STATE_EXPIRED => 'Expired \ Fulfilled',
                        MarketOrder::ORDER_STATE_CANCELLED => 'Cancelled',
                        MarketOrder::ORDER_STATE_PENDING => 'Pending',
                        MarketOrder::ORDER_STATE_CHAR_DELETED => 'Deleted'
                    ]
                ]
            ]
        ]); ?>

        <?php Pjax::end(); ?>
    </div>

    <div class="panel-footer"></div>
</div>