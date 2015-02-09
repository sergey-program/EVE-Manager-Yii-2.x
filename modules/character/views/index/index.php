<div class="panel panel-default">
    <div class="panel-heading">
        <div class="pull-right">ID: <?= $mCharacter->characterID; ?></div>
        <h1 class="panel-title">Character :: <?= $mCharacter->characterName; ?></h1>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-sm-3 text-center">
                <img class="img-thumbnail" src="https://image.eveonline.com/Corporation/<?= $mCharacter->corporationID; ?>_128.png">
                <h3><?= $mCharacter->corporationName; ?></h3>
            </div>

            <div class="col-sm-6 text-center">
                <img class="img-thumbnail" src="https://image.eveonline.com/Character/<?= $mCharacter->characterID; ?>_256.jpg">
                <h3><?= $mCharacter->characterName; ?></h3>
            </div>

            <div class="col-sm-3 text-center">
                <?php if ($mCharacter->allianceID): ?>
                    <img class="img-thumbnail" src="https://image.eveonline.com/Alliance/<?= $mCharacter->allianceID; ?>_128.png">
                    <h3><?= $mCharacter->allianceName; ?></h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>