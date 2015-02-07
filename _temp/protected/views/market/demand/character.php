<?php $this->sTitle = 'Market Demands'; ?>
<script type="text/javascript" src="/public/js/page-demand.js"></script>

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
        </div>
        <!-- col -->
    </div>
    <!-- row -->

    <!-- add demand -->
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $form = $this->beginWidget('CActiveForm', array('htmlOptions' => array('role' => 'form', 'style' => 'width: 100%;'))); ?>

                    <div class="form-group">
                        <?php echo $form->textField($oDemand, 'stationID', array('class' => 'form-control')); ?>
                    </div>

                    <div class="form-group">
                        <?php echo $form->textField($oDemand, 'typeID', array('class' => 'form-control')); ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4">
                            <?php echo $form->textField($oDemand, 'quantity', array('class' => 'form-control text-center', 'placeholder' => 'quantity')); ?>
                        </div>
                        <div class="col-sm-4">
                            <?php echo $form->dropDownList($oDemand, 'demandType', array(MarketDemand::TYPE_SELL => MarketDemand::TYPE_SELL, MarketDemand::TYPE_BUY => MarketDemand::TYPE_BUY), array('class' => 'form-control text-center')); ?>
                        </div>
                        <div class="col-sm-4 text-center">
                            <?php echo CHtml::submitButton('Add new Demand', array('class' => 'btn btn-primary')); ?>
                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
            <!-- panel -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php if ($cCharacter->getDemandsCount()): ?>
                <ul class="list-group">
                    <?php foreach ($cCharacter->getDemandsAsStationList() as $cStation): ?>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $cStation->getDemandsCount($cCharacter->getCharacterID()); ?></span>
                            <div class="dropdown dropdown-inline">
                                <a href="#" data-toggle="dropdown"><img class="img-thumbnail" src="http://image.eveonline.com/Type/<?php echo $cStation->getStationTypeID(); ?>_32.png"></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Delete location</a></li>
                                    <li><a href="#">Delete all demands</a></li>
                                </ul>
                            </div>
                            <a class="margin-left-15" href="<?php echo Yii::app()->createUrl('market/demand/station', array('sCharacterID' => $cCharacter->getCharacterID(), 'sStationID' => $cStation->getStationID())); ?>"><?php echo $cStation->getStationName(); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="alert alert-warning text-center">Has no demands...</p>
            <?php endif; ?>
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>
<!-- container -->