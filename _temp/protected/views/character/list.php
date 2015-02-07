<?php $this->sTitle = 'Character list'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php if ($aCharacter) : ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">Character list</h1>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <?php foreach ($aCharacter as $cCharacter): ?>
                                <li class="list-group-item">
                                    <?php echo $cCharacter->getCharacterName(); ?>
                                    <a href="<?php echo Yii::app()->createUrl('market/order/character', array('sCharacterID' => $cCharacter->getCharacterID())); ?>" class="pull-right"><img src="/public/img/market.png" title="market orders" width="24"></a>
                                    <a href="<?php echo Yii::app()->createUrl('market/demand/character', array('sCharacterID' => $cCharacter->getCharacterID())); ?>" class="pull-right"><img src="/public/img/market.png" title="market orders" width="24"></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <p class="alert alert-warning text-center">No characters presented...</p>
            <?php endif; ?>
            <!-- panel -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>
<!-- container -->