<?php

use yii\helpers\Url;

/**
 * @var app\components\ViewExtended $this
 * @var app\models\Api[]            $apis
 */
?>

<div class="row">
    <div class="col-md-12">

        <p class="text-center">
            <a href="<?= Url::to(['api/add']); ?>" class="btn btn-primary">Add new api</a>
        </p>

        <?php if ($apis) : ?>
            <?php foreach ($apis as $api): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title">ID #<?= $api->id; ?></h1>
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item"><?= $api->getAttributeLabel('keyID'); ?>: <?= $api->keyID; ?></li>
                            <li class="list-group-item"><?= $api->getAttributeLabel('vCode'); ?>: <?= $api->vCode; ?></li>
                        </ul>

                        <?php if ($api->info): ?>
                            <small class="pull-right text-muted"><?= \Yii::$app->formatter->asDatetime($api->info->timeUpdated); ?></small>
                            <h3>Key Info <?php if ($api->isFullAccess()): ?><span class="text-success">Full</span><?php endif; ?></h3>

                            <ul class="list-group">
                                <li class="list-group-item"><?= $api->info->getAttributeLabel('type'); ?>: <?= $api->info->type; ?></li>
                                <li class="list-group-item"><?= $api->info->getAttributeLabel('accessMask'); ?>: <?= $api->info->accessMask; ?></li>
                                <li class="list-group-item"><?= $api->info->getAttributeLabel('expires'); ?>: <?= \Yii::$app->formatter->asDatetime($api->info->expires); ?></li>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Key Info not updated...</p>
                        <?php endif; ?>

                        <?php if ($api->characters): ?>
                            <small class="pull-right text-muted"></small>
                            <h3>Characters</h3>

                            <ul class="list-group">
                                <?php foreach ($api->characters as $character): ?>
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-2 text-center">
                                                <img class="img-thumbnail" title="<?= $character->characterName; ?>" src="<?= $character->getImageSrc(128); ?>">
                                            </div>

                                            <div class="col-md-10">
                                                <table class="table table-hover table-condensed">
                                                    <tr>
                                                        <td width="125"><?= $character->characterID; ?></td>
                                                        <td><?= $character->characterName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $character->corporationID; ?></td>
                                                        <td><?= $character->corporationName; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= \Yii::$app->formatter->asText($character->allianceID); ?></td>
                                                        <td><?= \Yii::$app->formatter->asText($character->allianceName); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="text-right text-muted small">
                                                            <?= \Yii::$app->formatter->asDatetime($character->timeUpdated); ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">No character entries...</p>
                        <?php endif; ?>
                    </div>

                    <div class="panel-footer text-center">
                        <a href="<?= Url::to(['api/update', 'apiID' => $api->id]); ?>" class="btn btn-info">Update</a>
                        <a href="<?= Url::to(['api/delete', 'apiID' => $api->id]); ?>" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>
