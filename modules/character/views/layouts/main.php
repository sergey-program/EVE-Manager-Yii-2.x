<?php

use yii\helpers\Url;

/**
 * @var app\components\ViewExtended $this
 * @var string                      $content
 */
?>

<?php $this->beginContent('@app/views/layouts/backend.php'); ?>

    <div class="row">
        <div class="col-md-2">
            <div class="list-group">
                <a class="list-group-item text-center" href="<?= Url::to(['index/index', 'characterID' => $this->getCharacter()->characterID]); ?>"><?= $this->getCharacter()->characterName; ?></a>
            </div>

            <div class="list-group">
                <a class="list-group-item" href="<?= Url::to(['market/index', 'characterID' => $this->getCharacter()->characterID]); ?>">Market</a>
                <a class="list-group-item disabled" href="<?= Url::to(['assets/index', 'characterID' => $this->getCharacter()->characterID]); ?>">Assets</a>
            </div>
        </div>

        <div class="col-md-10">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>