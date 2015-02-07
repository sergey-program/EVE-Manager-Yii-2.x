<?php $this->sTitle = 'Station Orders'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <img class="img-thumbnail margin-right-15" src="http://image.eveonline.com/Character/<?php echo $cCharacter->getCharacterID(); ?>_32.jpg">
                    <?php echo $cCharacter->getCharacterName(); ?>
                </div>
            </div>
            <!-- panel -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <img class="img-thumbnail margin-right-15" src="http://image.eveonline.com/Type/<?php echo $cStation->getStationTypeID(); ?>_32.png">
                    <?php echo $cStation->getStationName(); ?>
                </div>
            </div>
            <!-- panel -->
            <?php if ($cCharacter->getDemandsCount($cStation->getStationID(), clDemand::TYPE_SELL)): ?>
                <h1>Sell</h1>
                <ul class="list-group">
                    <?php foreach ($cStation->getDemands($cCharacter->getCharacterID(), clDemand::TYPE_SELL) as $cDemand): ?>
                        <li class="list-group-item list-group-item-success">
                            <div class="pull-right line-height-42">Need: <strong><?php echo $cDemand->getNeed($cCharacter->getCharacterID()); ?></strong> Demand: <?php echo $cDemand->getQuantity(); ?></div>
                            <img class="img-thumbnail" src="http://image.eveonline.com/Type/<?php echo $cDemand->getTypeID(); ?>_32.png">
                            <span class=" margin-left-15"><?php echo $cDemand->getTypeName(); ?></span>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>Jita Buy:</span>
                                            <div class="pull-right"><?php echo number_format($cDemand->getPriceBuy(), 2, ',', ' '); ?></div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>Jita Sell:</span>
                                            <div class="pull-right"><?php echo number_format($cDemand->getPriceSell(), 2, ',', ' '); ?></div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>My Buy:</span>
                                            <div class="pull-right">
                                                <span class="text-muted"><small>-<?php echo cPrice::getPercentSell(); ?>%</small></span>
                                                <?php echo number_format($cDemand->getPriceBuy(true), 2, ',', ' '); ?>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>My Sell:</span>
                                            <div class="pull-right">
                                                <span class="text-muted"><small>+<?php echo cPrice::getPercentBuy(); ?>%</small></span>
                                                <?php echo number_format($cDemand->getPriceSell(true), 2, ',', ' '); ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- col -->
                                <div class="col-md-6">
                                    <ul class="list-group margin-bottom-0">
                                        <?php if ($cDemand->getOrders($cCharacter->getCharacterID())): ?>
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

            <?php if ($cCharacter->getDemandsCount($cStation->getStationID(), clDemand::TYPE_BUY)): ?>
                <h1>Buy</h1>
                <ul class="list-group">
                    <?php foreach ($cStation->getDemands($cCharacter->getCharacterID(), clDemand::TYPE_BUY) as $cDemand): ?>
                        <li class="list-group-item list-group-item-success">
                            <div class="pull-right line-height-42">Need: <strong><?php echo $cDemand->getNeed($cCharacter->getCharacterID()); ?></strong> Demand: <?php echo $cDemand->getQuantity(); ?></div>
                            <img class="img-thumbnail" src="http://image.eveonline.com/Type/<?php echo $cDemand->getTypeID(); ?>_32.png">
                            <span class="margin-left-15"><?php echo $cDemand->getTypeName(); ?></span>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span>Jita Buy:</span>
                                            <div class="pull-right"><?php echo number_format($cDemand->getPriceBuy(), 2, ',', ' '); ?></div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>Jita Sell:</span>
                                            <div class="pull-right"><?php echo number_format($cDemand->getPriceSell(), 2, ',', ' '); ?></div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>My Buy:</span>
                                            <div class="pull-right">
                                                <span class="text-muted"><small>-<?php echo cPrice::getPercentSell(); ?>%</small></span>
                                                <?php echo number_format($cDemand->getPriceBuy(true), 2, ',', ' '); ?>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span>My Sell:</span>
                                            <div class="pull-right">
                                                <span class="text-muted"><small>+<?php echo cPrice::getPercentBuy(); ?>%</small></span>
                                                <?php echo number_format($cDemand->getPriceSell(true), 2, ',', ' '); ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- col -->
                                <div class="col-md-6">
                                    <ul class="list-group margin-bottom-0">
                                        <?php if ($cDemand->getOrders($cCharacter->getCharacterID())): ?>
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
                <p class="alert alert-warning text-center">Has no buy demands...</p>
            <?php endif; ?>
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>
<!-- container -->