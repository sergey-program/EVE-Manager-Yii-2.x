<?php

use yii\helpers\Url;

/**
 * @var app\components\ViewExtended $this
 * @var string                      $content
 */
?>

<?php $this->beginContent('@app/views/layouts/backend.php'); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a class="list-group-item" href="<?= Url::to(['index/index', 'characterID' => \Yii::$app->params['character']->characterID]); ?>">
                    <span><i class="glyphicon glyphicon-chevron-right pull-right">&nbsp;</i> Index</span>
                </a>

                <a class="list-group-item" href="<?= Url::to(['market/index', 'characterID' => \Yii::$app->params['character']->characterID]); ?>">
                    <span><i class="glyphicon glyphicon-chevron-right pull-right">&nbsp;</i> Market</span>
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>