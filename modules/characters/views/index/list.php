<?php

use yii\helpers\Url;

/**
 * @var app\components\ViewExtended        $this
 * @var app\models\api\account\Character[] $characters
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">List</h1>
    </div>

    <div class="panel-body">

        <?php if ($characters) : ?>
            <ul class="list-group">

                <?php foreach ($characters as $character): ?>
                    <li class="list-group-item">
                        <img class="img-thumbnail" src="<?= $character->getCorporationImageSrc(); ?>" title="<?= $character->corporationName; ?>">
                        <img class="img-thumbnail" src="<?= $character->getImageSrc(); ?>" title="<?= $character->characterName; ?>">
                        
                        <a href="<?= Url::to(['/character/index/index', 'characterID' => $character->characterID]); ?>">
                            <?= $character->characterName; ?>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>
        <?php else: ?>
            <p class="alert alert-warning text-center">No characters presented...</p>
        <?php endif; ?>
    </div>
</div>