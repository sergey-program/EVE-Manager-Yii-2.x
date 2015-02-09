<?php use yii\helpers\Url; ?>

<?php if ($aApi) : ?>
    <?php foreach ($aApi as $mApi): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">
                    <div class="pull-right"><?= $mApi->keyID; ?></div>
                    <span>#<?= $mApi->id; ?></span>
                </h1>
            </div>

            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">keyID: <?= $mApi->keyID; ?></li>
                    <li class="list-group-item">vCode: <?= $mApi->vCode; ?></li>
                </ul>

                <?php if ($mApi->info): ?>
                    <h3>
                        <?php if ($mApi->info->accessMask == '268435455'): ?>
                            <div class="pull-right text-success">Full</div>
                        <?php endif; ?>
                        <span>Key Info</span>
                    </h3>
                    <ul class="list-group">
                        <li class="list-group-item">Type: <?= $mApi->info->type; ?></li>
                        <li class="list-group-item">Access Mask: <?= $mApi->info->accessMask; ?></li>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Key Info not updated...</p>
                <?php endif; ?>

                <?php if ($mApi->characters): ?>
                    <h3>Characters</h3>
                    <ul class="list-group">
                        <?php foreach ($mApi->characters as $mCharacter): ?>
                            <li class="list-group-item">
                                <span><img class="img-thumbnail" src="https://image.eveonline.com/character/<?= $mCharacter->characterID; ?>_32.jpg"></span>
                                <span><?= $mCharacter->characterName; ?></span> <span class="text-muted"><?= $mCharacter->corporationName; ?></span>
                                <div class="pull-right text-muted" title="characterID"><?= $mCharacter->characterID; ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">No character entries...</p>
                <?php endif; ?>
            </div>
            <div class="panel-footer text-center">
                <a href="<?= Url::to(['/api/index/list', 'updateApi' => $mApi->id]); ?>" class="btn btn-info">Update</a>
                <a href="<?= Url::to(['/api/index/delete', 'id' => $mApi->id]); ?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="alert alert-danger text-center">No api presented.</p>
<?php endif; ?>