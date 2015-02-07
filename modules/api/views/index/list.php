<?php use yii\helpers\Url; ?>

<?php if ($aApi) : ?>
    <?php foreach ($aApi as $mApi): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">
                    <div class="pull-right"><?php echo $mApi->keyID; ?></div>
                    <span>#<?php echo $mApi->id; ?></span>
                </h1>
            </div>

            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">keyID: <?php echo $mApi->keyID; ?></li>
                    <li class="list-group-item">vCode: <?php echo substr($mApi->vCode, 0, 20); ?>...</li>
                </ul>

                <?php if ($mApi->hasInfo()): ?>
                    <h3>Key Info</h3>
                    <ul class="list-group">
                        <li class="list-group-item">Type: <?php echo $cApi->getType(); ?></li>
                        <li class="list-group-item">Access Mask: <?php echo $cApi->getAccessMask(); ?></li>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Key Info not updated...</p>
                <?php endif; ?>

                <?php if ($mApi->hasCharacters()): ?>
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
            <div class="panel-footer text-center">
                <a href="<?php //echo Yii::app()->createUrl('api/update', array('sApiID' => $cApi->getID())); ?>" class="btn btn-xs btn-info">Update</a>
                <a href="<?= Url::to(['/api/index/delete', 'id' => $mApi->id]); ?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="alert alert-danger text-center">No api presented.</p>
<?php endif; ?>