<?php use app\models\MarketDemand; ?>
<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right"><?= $mCharacter->characterName; ?></div>
        <h1 class="panel-title">Demand List</h1>
    </div>

    <div class="panel-body">
        <?php if ($aMarketDemand): ?>
            <ul class="list-group">
                <?php foreach ($aMarketDemand as $mMarketDemand): ?>
                    <?php
                    if ($mMarketDemand->getCountOrders() >= $mMarketDemand->quantity) {
                        $sColor = 'list-group-item-success';
                    } elseif (($mMarketDemand->quantity / 2) > $mMarketDemand->getCountNeed()) {
                        $sColor = 'list-group-item-warning';
                    } else {
                        $sColor = 'list-group-item-danger';
                    }
                    ?>

                    <li class="list-group-item <?= $sColor; ?>">
                        <div class="pull-right" style="line-height: 42px;">
                            <?php if ($mMarketDemand->getCountNeed() > 0): ?>
                                <span>Need: <strong><?= number_format($mMarketDemand->getCountNeed(), 0, '.', ' '); ?></strong></span>
                            <?php endif; ?>
                            <span>Current: <strong><?= number_format($mMarketDemand->getCountOrders(), 0, '.', ' '); ?></strong></span>
                            <span>Demand: <?= number_format($mMarketDemand->quantity, 0, '.', ' '); ?></span>
                        </div>

                        <span data-action="toggle-info" data-target="<?= $mMarketDemand->id; ?>">
                            <img class="img-thumbnail" src="http://image.eveonline.com/Type/<?= $mMarketDemand->typeID; ?>_32.png">
                        </span>

                        <span style="font-weight: bold;"><?= $mMarketDemand->invTypes->typeName; ?></span>
                        <span class="margin-left-15"><?php if ($mMarketDemand->type == MarketDemand::TYPE_BUY): ?>Buy <?php else: ?>Sell <?php endif; ?></span>
                    </li>

                    <li class="list-group-item" data-info="<?= $mMarketDemand->id; ?>" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span>Jita Buy:</span>
                                        <div class="pull-right"><?php //echo number_format($cDemand->getPriceBuy(), 2, ',', ' '); ?></div>
                                    </li>
                                    <li class="list-group-item">
                                        <span>Jita Sell:</span>
                                        <div class="pull-right"><?php //echo number_format($cDemand->getPriceSell(), 2, ',', ' '); ?></div>
                                    </li>
                                    <li class="list-group-item">
                                        <span>My Buy:</span>
                                        <div class="pull-right">
                                            <span class="text-muted"><small>-<?php //echo cPrice::getPercentSell(); ?>%</small></span>
                                            <?php //echo number_format($cDemand->getPriceBuy(true), 2, ',', ' '); ?>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <span>My Sell:</span>
                                        <div class="pull-right">
                                            <span class="text-muted"><small>+<?php //echo cPrice::getPercentBuy(); ?>%</small></span>
                                            <?php //echo number_format($cDemand->getPriceSell(true), 2, ',', ' '); ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <ul class="list-group margin-bottom-0">
                                    <?php if ($mMarketDemand->orders): ?>
                                        <?php foreach ($mMarketDemand->orders as $mMarketOrder): ?>
                                            <li class="list-group-item list-group-item-info">
                                                <div class="pull-right"><?= number_format($mMarketOrder->volRemaining, 0, '.', ' '); ?> / <?= number_format($mMarketOrder->volEntered, 0, '.', ' '); ?></div>
                                                <span>#<?= $mMarketOrder->orderID; ?></span>
                                                <span class="text-muted"> <?= number_format($mMarketOrder->price, 2, '.', ' '); ?> isk</span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="list-group-item list-group-item-danger text-center">no orders</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <?= Html::a('Delete demand', ['/character/market-demands/delete', 'characterID' => $mCharacter->characterID, 'id' => $mMarketDemand->id], ['class' => 'btn btn-xs btn-danger']); ?>
                            </div>
                        </div>

                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-warning text-center">Has no sell demands...</p>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('[data-action="toggle-info"]')
            .css('cursor', 'pointer')
            .click(function () {
                $('[data-info="' + $(this).attr('data-target') + '"]').toggle();
            });
    });
</script>