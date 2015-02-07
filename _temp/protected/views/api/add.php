<?php $this->sTitle = 'Add new api'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Add new api.</h1>
                </div>
                <div class="panel-body">
                    <?php $oForm = $this->beginWidget('CActiveForm', array('htmlOptions' => array('role' => 'form', 'class' => 'form-horizontal'))); ?>

                    <div class="form-group">
                        <?php echo $oForm->labelEx($oApi, 'keyID', array('class' => 'control-label col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $oForm->textField($oApi, 'keyID', array('class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $oForm->labelEx($oApi, 'vCode', array('class' => 'control-label col-md-4')); ?>
                        <div class="col-md-8">
                            <?php echo $oForm->textField($oApi, 'vCode', array('class' => 'form-control')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo CHtml::submitButton('Add', array('class' => 'btn btn-default center-block')); ?>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
            <!-- panel -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>
<!-- container -->