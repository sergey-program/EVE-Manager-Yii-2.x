<?php

use yii\helpers\Url;

/**
 * @var app\components\ViewExtended        $this
 * @var app\models\api\account\Character[] $characters
 */
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">

        <?php if ($characters) : ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Characters</h1>
                </div>

                <div class="panel-body">
                    <ul class="list-group">

                        <?php foreach ($characters as $character): ?>
                            <li class="list-group-item">
                                <?php if ($character->allianceID): ?>
                                    <img class="img-thumbnail" src="<?= $character->getAllianceImageSrc(); ?>" title="<?= $character->allianceName; ?>">
                                <?php else: ?>
                                    <div style="width:42px; display: inline-block;">&nbsp;</div>
                                <?php endif; ?>


                                <img class="img-thumbnail" src="<?= $character->getCorporationImageSrc(); ?>" title="<?= $character->corporationName; ?>">
                                <img class="img-thumbnail" src="<?= $character->getImageSrc(); ?>" title="<?= $character->characterName; ?>">

                                <a href="<?= Url::to(['/character/index/index', 'characterID' => $character->characterID]); ?>" style="margin-left: 10px;">
                                    <?= $character->characterName; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        <?php else: ?>
            <p class="alert alert-warning text-center">No characters presented...</p>
        <?php endif; ?>

    </div>
</div>