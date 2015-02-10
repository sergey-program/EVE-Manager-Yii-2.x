<?php use app\models\MarketDemand; ?>
<?php use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right"><?= $this->getController()->mCharacter->characterName; ?></div>
        <h1 class="panel-title">Demands :: List</h1>
    </div>

    <div class="panel-body">
        <?php if ($aMarketDemand): ?>

            <form data-action="filter" class="form-horizontal">
                <select class="form-control">
                    <option value="0">Show all</option>
                    <option value="1">Success</option>
                    <option value="2">Warning</option>
                    <option value="3">Danger</option>
                    <option value="4">Warning and Danger</option>
                </select>
            </form>
            <br/>
            <ul class="list-group">
                <?php foreach ($aMarketDemand as $mMarketDemand): ?>
                    <?php
                    if ($mMarketDemand->getCountOrders() >= $mMarketDemand->quantity) {
                        $sColor = 'list-group-item-success';
                        $iFilterType = 1;
                    } elseif (($mMarketDemand->quantity / 2) > $mMarketDemand->getCountNeed()) {
                        $sColor = 'list-group-item-warning';
                        $iFilterType = 2;
                    } else {
                        $sColor = 'list-group-item-danger';
                        $iFilterType = 3;
                    }
                    ?>

                    <li class="list-group-item <?= $sColor; ?>" data-filter-type="<?= $iFilterType; ?>">
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

                    <li class="list-group-item" data-info="<?= $mMarketDemand->id; ?>" data-filter-type="<?= $iFilterType; ?>" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="pull-right text-muted">Jita</div>
                                        <span class="text-muted">Buy:</span> <?= number_format($mMarketDemand->priceBuy->max, 2, '.', ' '); ?>
                                        <span class="text-muted">Sell:</span> <?= number_format($mMarketDemand->priceSell->min, 2, '.', ' '); ?>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="pull-right text-muted">
                                            <span class="text-muted"><small>-<?= Yii::$app->params['demand']['percent']['buy']; ?>% / +<?= Yii::$app->params['demand']['percent']['sell']; ?>%</small></span>
                                        </div>
                                        <span class="text-muted">Buy:</span> <?= number_format($mMarketDemand->getMarginPriceBuy(false, false), 2, '.', ' '); ?>
                                        <span class="text-muted">Sell:</span> <?= number_format($mMarketDemand->getMarginPriceSell(false, false), 2, '.', ' '); ?>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="pull-right text-muted">
                                            <span class="text-muted"><small>Station <?= Yii::$app->params['demand']['stationPercent']; ?>%</small></span>
                                        </div>
                                        <span class="text-muted">Buy:</span> <?= number_format($mMarketDemand->getMarginPriceBuy(false, true), 2, '.', ' '); ?>
                                        <span class="text-muted">Sell:</span> <?= number_format($mMarketDemand->getMarginPriceSell(false, true), 2, '.', ' '); ?>
                                    </li>

                                    <li class="list-group-item">
                                        <div class="pull-right text-muted">
                                            <span class="text-muted"><small>+<?= number_format(Yii::$app->params['demand']['iskPerM3'], 0, '.', ' '); ?> isk pm3</small></span>
                                        </div>
                                        <span class="text-muted">Buy:</span> <?= number_format($mMarketDemand->getMarginPriceBuy(), 2, '.', ' '); ?>
                                        <span class="text-muted">Sell:</span> <?= number_format($mMarketDemand->getMarginPriceSell(), 2, '.', ' '); ?>
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
                                <?= Html::a('Delete demand', ['/character/market-demands/delete', 'characterID' => $this->getController()->mCharacter->characterID, 'id' => $mMarketDemand->id], ['class' => 'btn btn-xs btn-danger']); ?>
                            </div>
                        </div>

                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-warning text-center">Has no demands...</p>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    // @todo refactor for someone else, bad solution
    $(document).ready(function () {
        $('[data-action="toggle-info"]').css('cursor', 'pointer').click(function () {
            $('[data-info="' + $(this).attr('data-target') + '"]').toggle();
        });

        $('[data-action="filter"] select').change(function () {
            var iFilterType = $(this).val();

            $('[data-filter-type]').each(function () {
                if (iFilterType == 4) {
                    if ($(this).attr('data-filter-type') == 2 || $(this).attr('data-filter-type') == 3) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                } else if (iFilterType == 0) {
                    $(this).show();
                }
                else {
                    if (iFilterType != $(this).attr('data-filter-type')) {
                        $(this).hide();
                    } else {
                        $(this).show()
                    }
                }
            });
        });
    });
</script>