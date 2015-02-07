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
            <?php if ($cStation->getOrdersCount($cCharacter->getCharacterID())): ?>
                <ul class="list-group">
                    <?php foreach ($cStation->getOrders($cCharacter->getCharacterID()) as $cOrder): ?>
                        <li class="list-group-item">
                            <div class="pull-right line-height-42"><?php echo $cOrder->getVolRemaining(); ?> / <?php echo $cOrder->getVolEntered(); ?></div>
                            <img class="img-thumbnail margin-right-15" src="http://image.eveonline.com/Type/<?php echo $cOrder->getTypeID(); ?>_32.png">
                            <?php echo $cOrder->getTypeName(); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="alert alert-warning text-center">Has no orders...</p>
            <?php endif; ?>
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>
<!-- container -->