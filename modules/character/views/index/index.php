<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right">ID: <?= $this->getController()->mCharacter->characterID; ?></div>
        <h1 class="panel-title">Character :: <?= $this->getController()->mCharacter->characterName; ?></h1>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3 text-center">
                <img class="img-thumbnail" src="https://image.eveonline.com/Corporation/<?= $this->getController()->mCharacter->corporationID; ?>_128.png">
                <h3><?= $this->getController()->mCharacter->corporationName; ?></h3>
            </div>

            <div class="col-sm-6 text-center">
                <img class="img-thumbnail" src="https://image.eveonline.com/Character/<?= $this->getController()->mCharacter->characterID; ?>_256.jpg">
                <h3><?= $this->getController()->mCharacter->characterName; ?></h3>
            </div>

            <div class="col-sm-3 text-center">
                <?php if ($this->getController()->mCharacter->allianceID): ?>
                    <img class="img-thumbnail" src="https://image.eveonline.com/Alliance/<?= $this->getController()->mCharacter->allianceID; ?>_128.png">
                    <h3><?= $this->getController()->mCharacter->allianceName; ?></h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>