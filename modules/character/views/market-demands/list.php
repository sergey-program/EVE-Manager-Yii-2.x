<?php ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Demand List</h1>
    </div>

    <div class="panel-body">
        <?php if ($aMarketDemand): ?>
            <ul class="list-group">
                <?php foreach ($aMarketDemand as $mMarketDemand): ?>
                    <li class="list-group-item list-group-item-success">
                        <div class="pull-right" style="line-height: 42px;">Need: <strong><?= $mMarketDemand->quantity; ?></strong> Demand: <?= $mMarketDemand->quantity; ?></div>
                        <img class="img-thumbnail" src="http://image.eveonline.com/Type/<?= $mMarketDemand->typeID; ?>_32.png">
                        <span style="font-weight: bold;"><?= $mMarketDemand->invTypes->typeName; ?></span>
                        <span class="margin-left-15">Sell \ Buy<?php //echo $cDemand->getTypeName(); ?></span>
                    </li>
                    <li class="list-group-item">
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
                            <!-- col -->
                            <div class="col-md-6">
                                <ul class="list-group margin-bottom-0">
                                    <?php if (false): //$cDemand->getOrders($cCharacter->getCharacterID())): ?>
                                        <?php foreach ($cDemand->getOrders($cCharacter->getCharacterID()) as $cOrder): ?>
                                            <li class="list-group-item list-group-item-info">
                                                <div class="pull-right"><?php echo $cOrder->getVolRemaining(); ?> / <?php echo $cOrder->getVolEntered(); ?></div>
                                                <span>#<?php echo $cOrder->getOrderID(); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="list-group-item list-group-item-danger text-center">no orders</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <!-- col -->
                        </div>
                        <!-- row -->
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-warning text-center">Has no sell demands...</p>
        <?php endif; ?>
    </div>

    <div class="panel-footer"></div>
</div>