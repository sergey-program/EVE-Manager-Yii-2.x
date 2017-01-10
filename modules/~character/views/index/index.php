<?php

/**
 * @var app\components\ViewExtended $this
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title"> <?= $this->getCharacter()->characterID; ?> :: <?= $this->getCharacter()->characterName; ?></h1>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3 text-center">
                <img class="img-thumbnail" src="<?= $this->getCharacter()->getCorporationImageSrc(128); ?>">
                <h3><?= $this->getCharacter()->corporationName; ?></h3>
            </div>

            <div class="col-sm-6 text-center">
                <img class="img-thumbnail" src="<?= $this->getCharacter()->getImageSrc(256); ?>">
                <h3><?= $this->getCharacter()->characterName; ?></h3>
            </div>

            <div class="col-sm-3 text-center">
                <?php if ($this->getCharacter()->allianceID): ?>
                    <img class="img-thumbnail" src="<?= $this->getCharacter()->getAllianceImageSrc(128); ?>">
                    <h3><?= $this->getCharacter()->allianceName; ?></h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>