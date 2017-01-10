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
            <div class="list-group text-center">
                <a class="list-group-item" href="<?= Url::to(['index/index', 'characterID' => $this->getCharacter()->characterID]); ?>"><?= $this->getCharacter()->characterName; ?></a>
            </div>

            <div class="list-group">
                <a class="list-group-item" href="<?= Url::to(['order/index', 'characterID' => $this->getCharacter()->characterID]) ?>">Orders</a>
                <a class="list-group-item" href="<?= Url::to(['demand/index', 'characterID' => $this->getCharacter()->characterID]) ?>">Demands</a>
            </div>
        </div>

        <div class="col-md-10">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>