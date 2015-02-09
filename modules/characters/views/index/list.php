<?php use yii\helpers\Url; ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">Character List</h1>
    </div>

    <div class="panel-body">
        <?php if ($aCharacter) : ?>
            <ul class="list-group">
                <?php foreach ($aCharacter as $mCharacter): ?>
                    <li class="list-group-item">
                        <img class="img-thumbnail" src="https://image.eveonline.com/Character/<?= $mCharacter->characterID; ?>_32.jpg">
                        <a href="<?= Url::to(['/character/index/index', 'characterID'=> $mCharacter->characterID]); ?>"><?= $mCharacter->characterName; ?></a>
                        <a href="<?= Url::to('/'); ?>" class="pull-right"><img src="/public/img/market.png" title="market orders" width="24"></a>
                        <a href="<?= Url::to('/'); ?>" class="pull-right"><img src="/public/img/market.png" title="market orders" width="24"></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="alert alert-warning text-center">No characters presented...</p>
        <?php endif; ?>
    </div>

    <div class="panel-footer"></div>
</div>