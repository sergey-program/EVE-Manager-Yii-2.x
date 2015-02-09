<?php use yii\helpers\Url; ?>

<?php $this->beginContent('@app/views/layouts/backend.php'); ?>

    <?php $characterID = $this->getFromUrl('characterID'); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a class="list-group-item" href="<?= Url::to(['/character/index/index', 'characterID' => $characterID]); ?>">
                    <span><i class="glyphicon glyphicon-chevron-right pull-right">&nbsp;</i> Index</span>
                </a>

                <a class="list-group-item" href="<?= Url::to(['/character/market-orders/index', 'characterID' => $characterID]) ?>">
                    <span><i class="glyphicon glyphicon-chevron-right pull-right">&nbsp;</i> Market Orders</span>
                </a>

                <a class="list-group-item" href="<?= Url::to(['/character/market-demands/index', 'characterID' => $characterID]) ?>">
                    <span><i class="glyphicon glyphicon-chevron-right pull-right">&nbsp;</i> Market Demands</span>
                </a>
            </div>
        </div>

        <div class="col-md-9">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>