<?php

use app\models\api\character\MarketOrder;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var app\components\ViewExtended                                   $this
 * @var app\modules\character\modules\market\models\SearchMarketOrder $searchMarketOrder
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">List</h1>
    </div>

    <div class="panel-body">
        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'filterModel' => $searchMarketOrder,
            'dataProvider' => $searchMarketOrder->search(\Yii::$app->request->get()),
            'columns' => [
                [
                    'format' => 'image',
                    'value' => function ($model) {
                        return 'https://image.eveonline.com/Type/' . $model->typeID . '_32.png';
                    }
                ],
                ['attribute' => 'typeName', 'value' => 'invTypes.typeName', 'label' => 'Item'],
                ['attribute' => 'volRemaining', 'label' => 'Quantity'],
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
</div>