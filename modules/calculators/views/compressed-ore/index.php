<?php

/**
 * @var app\components\ViewExtended  $this
 * @var \app\models\dump\InvTypes[]  $invTypes
 * @var \app\models\dump\InvGroups[] $groups
 */

?>

<div class="row">
    <div class="col-md-6 col-lg-4">

        <?php foreach ($groups as $key => $group): ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="pull-right">
                        <?php $time = $group->marketUpdateGroup->timeUpdate ?? null; ?>
                        <small class="text-muted" style="margin-right: 20px;" title="Когда последний раз обновлялось"><?= \Yii::$app->formatter->asDatetime($time, 'Y-m-d HH:i:s'); ?></small>
                        <a href="<?= \yii\helpers\Url::to(['update-group', 'groupID' => $group->groupID]); ?>">Обновить цены</a>
                    </div>
                    <h3 class="box-title"><?= $group->groupName; ?></h3>

                </div>

                <div class="box-body">
                    <?php foreach ($group->getCompressedOre() as $invType): ?>
                        <?php $item = $invType->getItem(); ?>

                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-8">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $item->typeID; ?>" style="padding: 0; margin: 0;">
                                            <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail" style="margin-right: 10px;">
                                            <span style="font-size: 18px;"><?= $item->typeName; ?></span>
                                        </a>
                                    </div>

                                    <div class="col-md-4 text-right">
                                        <small>
                                            <span class="text-success" title="Sell"><?= \Yii::$app->formatter->asDecimal($item->getPriceSell()); ?></span>
                                            <br/>
                                            <span class="text-danger" title="Buy"><?= \Yii::$app->formatter->asDecimal($item->getPriceBuy()); ?></span>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div id="collapse<?= $item->typeID; ?>" class="panel-collapse collapse" style="height: 0;">

                                <div class="box-body">
                                    <?php foreach ($item->getReprocessResult() as $rItem): ?>
                                        <?= \app\modules\calculators\widgets\ReprocessItemWidget::widget(['item' => $rItem]); ?>
                                    <?php endforeach; ?>

                                    <hr/>

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <span title="Материалы по Sell цене">S: <?= \Yii::$app->formatter->asDecimal($item->getReprocessPriceSell()); ?></span>
                                            <br/>
                                            <span title="Материалы по Buy цене">B: <?= \Yii::$app->formatter->asDecimal($item->getReprocessPriceBuy()); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>

