<?php

/**
 * @var app\components\ViewExtended  $this
 * @var \app\models\dump\InvTypes[]  $invTypes
 * @var \app\models\dump\InvGroups[] $groups
 */

?>

<div class="row">

    <?php foreach ($groups as $key => $group): ?>
        <div class="col-md-6 col-lg-4">
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
                    <?php foreach ($group->getInvTypes()->andWhere(['portionSize' => 1])->andWhere('marketGroupID IS NOT NULL')->all() as $invType): ?>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <div class="row">
                                    <div class="col-md-8">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $invType->typeID; ?>" style="padding: 0; margin: 0;">
                                            <img src="https://image.eveonline.com/Type/<?= $invType->typeID; ?>_32.png" class="img-thumbnail" style="margin-right: 10px;">
                                            <span style="font-size: 18px;"><?= $invType->typeName; ?></span>
                                        </a>
                                    </div>

                                    <div class="col-md-4 text-right">
                                        <small>
                                            <?php $sellPrice = $invType->marketPrice ? $invType->marketPrice->sell : null; ?>
                                            <?php $buyPrice = $invType->marketPrice ? $invType->marketPrice->buy : null; ?>
                                            <span class="text-success" title="Sell"><?= \Yii::$app->formatter->asDecimal($sellPrice); ?></span>
                                            <br/>
                                            <span class="text-danger" title="Buy"><?= \Yii::$app->formatter->asDecimal($buyPrice); ?></span>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div id="collapse<?= $invType->typeID; ?>" class="panel-collapse collapse" style="height: 0;">
                                <?php
                                $col = new \app\components\eve\ItemCollection();
                                $col->addItem(new \app\components\eve\Item(['typeID' => $invType->typeID]));
                                ?>

                                <div class="box-body">
                                    <?php $totalBuy = 0; ?>
                                    <?php $totalSell = 0; ?>
                                    <?php foreach (\app\components\eve\ActionReprocess::run($col, 84)->getItems() as $item): ?>
                                        <div class="row" style="margin-bottom:5px;">
                                            <div class="col-md-2 text-center">
                                                <img src="https://image.eveonline.com/Type/<?= $item->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                                            </div>

                                            <div class="col-md-4">
                                                <?= $item->typeName; ?>
                                                <br/>
                                                <?php $percent = $item->quantity / 84; ?>
                                                <span class="text-muted"><?= ceil($percent * 100); ?> * 84% = <?= $item->quantity; ?></span>
                                            </div>

                                            <div class="col-md-3 text-right">
                                                <span class="text-muted" title="Sell"><?= number_format($item->priceSell, 2, '.', ' '); ?></span>
                                                <br/>
                                                <span class="text-muted" title="Buy"><?= number_format($item->priceBuy, 2, '.', ' '); ?></span>
                                            </div>


                                            <div class="col-md-3 text-right">
                                                <?= number_format($item->priceSell * $item->quantity, 2, '.', ' '); ?>
                                                <br/>
                                                <?= number_format($item->priceBuy * $item->quantity, 2, '.', ' '); ?>
                                            </div>
                                        </div>
                                        <?php $totalBuy += ($item->priceBuy * $item->quantity); ?>
                                        <?php $totalSell += ($item->priceSell * $item->quantity); ?>
                                    <?php endforeach; ?>

                                    <table class="table table-condensed table-hover table-bordered" style="margin-top:20px;">
                                        <tr>
                                            <td class="text-center">Минералов на сумму</td>
                                            <td class="text-center">Мы купили за</td>
                                            <td class="text-center">Профит</td>
                                        </tr>
                                        <tr class="text-success">
                                            <td class="text-center">
                                                S: <?= number_format($totalSell, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center">
                                                B: <?= number_format($sellPrice, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center" title="<?= $totalSell; ?> - <?= $sellPrice; ?>">
                                                <?= number_format($totalSell - $sellPrice, 2, '.', ' '); ?>
                                            </td>
                                        </tr>
                                        <tr class="text-success">
                                            <td class="text-center">
                                                B: <?= number_format($totalBuy, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center">
                                                S: <?= number_format($sellPrice, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center" title="<?= $totalBuy; ?> - <?= $buyPrice; ?>">
                                                <?= number_format($totalBuy - $sellPrice, 2, '.', ' '); ?>
                                            </td>
                                        </tr>

                                        <tr class="text-danger">
                                            <td class="text-center">
                                                S: <?= number_format($totalSell, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center">
                                                B: <?= number_format($buyPrice, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center" title="<?= $totalSell; ?> - <?= $sellPrice; ?>">
                                                <?= number_format($totalSell - $sellPrice, 2, '.', ' '); ?>
                                            </td>
                                        </tr>
                                        <tr class="text-danger">
                                            <td class="text-center">
                                                B: <?= number_format($totalBuy, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center">
                                                B: <?= number_format($buyPrice, 2, '.', ' '); ?>
                                            </td>
                                            <td class="text-center" title="<?= $totalBuy; ?> - <?= $buyPrice; ?>">
                                                <?= number_format($totalBuy - $buyPrice, 2, '.', ' '); ?>
                                            </td>
                                        </tr>
                                    </table>

                                    <p class="alert text-success" style="margin-bottom: 0;">


                                    </p>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>
