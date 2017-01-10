<?php $this->sTitle = 'Market Orders'; ?>

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
            <?php if ($cCharacter->getOrdersCount()): ?>
                <ul class="list-group">
                    <?php foreach ($cCharacter->getOrdersAsStationList() as $cStation): ?>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $cStation->getOrdersCount($cCharacter->getCharacterID()); ?></span>
                            <img class="img-thumbnail margin-right-15" src="http://image.eveonline.com/Type/<?php echo $cStation->getStationTypeID(); ?>_32.png">
                            <a href="<?php echo Yii::app()->createUrl('market/order/station', array('sCharacterID' => $cCharacter->getCharacterID(), 'sStationID' => $cStation->getStationID())); ?>"><?php echo $cStation->getStationName(); ?></a>
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