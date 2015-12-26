<?php

/**
 * @var app\components\ViewExtended      $this
 * @var app\models\api\account\Character $character
 */

// @todo refactor this shit!!! used in layout to create links
\Yii::$app->params['character'] = $character;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"> <?= $character->characterID; ?> :: <?= $character->characterName; ?></h1>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3 text-center">
                <img class="img-thumbnail" src="<?= $character->getCorporationImageSrc(128); ?>">
                <h3><?= $character->corporationName; ?></h3>
            </div>

            <div class="col-sm-6 text-center">
                <img class="img-thumbnail" src="<?= $character->getImageSrc(256); ?>">
                <h3><?= $character->characterName; ?></h3>
            </div>

            <div class="col-sm-3 text-center">
                <?php if ($character->allianceID): ?>
                    <img class="img-thumbnail" src="<?= $character->getAllianceImageSrc(128); ?>">
                    <h3><?= $character->allianceName; ?></h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>