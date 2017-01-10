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
                <a class="list-group-item" href="<?= Url::to(['index/index']) ?>">
                    <span><i class="glyphicon glyphicon-chevron-right pull-right">&nbsp;</i> Index</span>
                </a>

                <a class="list-group-item" href="<?= Url::to(['index/list']); ?>">
                    <span><i class="glyphicon glyphicon-chevron-right pull-right">&nbsp;</i> List</span>
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>