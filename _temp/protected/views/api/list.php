<?php $this->sTitle = 'Api list'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php if ($aApi): ?>
                <?php foreach ($aApi as $cApi): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="panel-title">
                                <span>#<?php echo $cApi->getID(); ?></span>
                                <div class="pull-right"><?php echo $cApi->getKeyID(); ?></div>
                            </h1>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">keyID: <?php echo $cApi->getKeyID(); ?></li>
                                <li class="list-group-item">vCode: <?php echo substr($cApi->getVCode(), 0, 20); ?>...</li>
                            </ul>

                            <?php if ($cApi->hasInfo()): ?>
                                <h3>Key Info</h3>
                                <ul class="list-group">
                                    <li class="list-group-item">Type: <?php echo $cApi->getType(); ?></li>
                                    <li class="list-group-item">Access Mask: <?php echo $cApi->getAccessMask(); ?></li>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Key Info not updated...</p>
                            <?php endif; ?>

                            <?php if ($cApi->hasCharacters()): ?>
                                <h3>Characters</h3>
                                <ul class="list-group">
                                    <?php foreach ($cApi->getCharacters() as $cCharacter): ?>
                                        <li class="list-group-item">
                                            <span><?php echo $cCharacter->getCharacterName(); ?></span>
                                            <div class="pull-right text-muted" title="characterID"><?php echo $cCharacter->getCharacterID(); ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">No character entries...</p>
                            <?php endif; ?>
                        </div>
                        <div class="panel-footer text-right">
                            <a href="<?php echo Yii::app()->createUrl('api/update', array('sApiID' => $cApi->getID())); ?>" class="btn btn-xs btn-info">Update</a>
                            <a href="<?php echo Yii::app()->createUrl('api/delete', array('sApiID' => $cApi->getID())); ?>" class="btn btn-xs btn-danger">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="alert alert-warning text-center">No api.</p>
            <?php endif; ?>
            <!-- panel -->
        </div>
        <!-- col -->
    </div>
    <!-- row -->
</div>
<!-- container -->