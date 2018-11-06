<?php

/**
 * @var \app\components\ViewExtended $this
 * @var \app\components\items\Item   $item
 */

/** @var \app\components\actions\ActionManufacture $actionManufacture */
$actionManufacture = \Yii::$app->actionManufacture;

?>

<div class="row">

    <div class="col-md-6 col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-right">
                    <?= $item->getBlueprint()->getSettings()->me; ?> / <?= $item->getBlueprint()->getSettings()->meHull; ?> / <?= $item->getBlueprint()->getSettings()->meRig; ?>

                    <a href="<?= \yii\helpers\Url::to(['settings/update', 'typeID' => $item->getBlueprint()->typeID]); ?>" title="Update bpo settings">
                        <img src="<?= $item->getBlueprint()->getImageSrc(); ?>" class="img-thumbnail" style="margin-left: 10px;">
                    </a>
                </div>

                <h3 class="box-title">
                    <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;">
                    <?= $item->typeName; ?>
                    <small class="text-muted"><?= $item->typeID; ?></small>
                </h3>
            </div>

            <div class="box-body">
                <?php if ($item->hasBlueprint()): ?>
                    <?php foreach ($actionManufacture->calculate($item->getBlueprint(), $item->getQuantity())->getItems() as $mItem): ?>
                        <?= $this->render('_row', ['mItem' => $mItem, 'p' => 0]); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text text-warning">Item has not blueprint.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php /*
    <div class="col-md-6 col-lg-4">
        <form class="form">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Materials</h3>
                </div>

                <div class="box-body no-padding">
                    <table class="table table-striped table-hover">
                        <?php foreach ($item->getBlueprint()->getTotalManufacture() as $pItem): ?>
                            <tr>
                                <td>
                                    <div>
                                        <img src="<?= $pItem->getImageSrc(); ?>" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                                        <?= number_format($pItem->getQuantity(), 0, '.', ' '); ?>
                                        <small class="text-muted"><?= $pItem->typeID; ?></small>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceSell()); ?>
                                    <br/>
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceBuy()); ?>
                                </td>
                                <td class="text-right">
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceTotalSell()); ?>
                                    <br/>
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceTotalBuy()); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td class="text-right">
                                <?= \Yii::$app->formatter->asDecimal($item->getBlueprint()->getTotalPriceSell()); ?>
                                <br/>
                                <?= \Yii::$app->formatter->asDecimal($item->getBlueprint()->getTotalPriceBuy()); ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-right"><strong>BPC</strong></td>
                            <td class="text-right">
                                <?= \Yii::$app->formatter->asInteger(0/*$mTotal->getPriceBlueprintRuns()* /); ?>
                            </td>
                        </tr>

                    </table>

                </div>
            </div>
        </form>
    </div>
    */ ?>
    <?php /*

    <div class="col-md-12">
        <div class="panel box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <table class="table table-hover">

                            <?php
                            $m = new \app\modules\calculators\components\MineralComponent();
                            $m->setMineralsCollection($item->getBlueprint()->getTotalManufacture());
                            $m->calculate();
                            ?>

                            <?php foreach ($m->getMineralsCollection()->getItems() as $iItem): ?>
                                <tr>
                                    <td style="width: 75px;">
                                        <img src="<?= $iItem->getImageSrc(); ?>" class="img-thumbnail">
                                    </td>

                                    <td>
                                        <?= \Yii::$app->formatter->asText($iItem->typeName); ?>
                                        <small class="text-muted"><?= $iItem->typeID; ?></small>
                                        <br/>
                                        <?= \Yii::$app->formatter->asInteger($iItem->getQuantity()); ?>
                                    </td>

                                    <td style="width: 100px;">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?= $m->getOreForMineral($iItem)->typeName ?? 'Not set'; ?> <span class="caret" style="margin-left: 5px;"></span>
                                            </button>

                                            <ul class="dropdown-menu">
                                                <?php foreach (\Yii::$app->selectorOres->getCompressed($iItem->typeID) as $i): ?>
                                                    <li>
                                                        <a href="<?= \yii\helpers\Url::to(['index/set-ore', 'typeID' => \Yii::$app->request->get('typeID'), 'mineralTypeID' => $iItem->typeID, 'oreTypeID' => $i->typeID]); ?>">
                                                            <?= $i->typeName; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>

                                                <li>
                                                    <a href="<?= \yii\helpers\Url::to(['index/set-ore', 'typeID' => \Yii::$app->request->get('typeID'), 'mineralTypeID' => $iItem->typeID, 'oreTypeID' => null]); ?>">
                                                        Clear
                                                    </a>
                                                </li>
                                                <?php /*
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        * / ?>
                                            </ul>
                                        </div>

                                        <?php /* <input class="form-control" type="text" name="" value="<?= $oreTypeID; ?>"> * / ?>
                                    </td>

                                    <td style="width: 75px;">
                                        <?php if ($iOre = $m->getOreForMineral($iItem)): ?>
                                            <img src="<?= $iOre->getImageSrc(); ?>" class="img-thumbnail">
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($iOre): ?>
                                            <?= \Yii::$app->formatter->asText($iOre->typeName); ?>
                                            <small class="text-muted"><?= $iOre->typeID; ?></small>
                                            <br/>
                                            <?= \Yii::$app->formatter->asInteger($iOre->getQuantity()); ?>
                                            <br/>
                                            <br/>
                                            <?php foreach ($iOre->getReprocessResult() as $rItem): ?>
                                                <img src="<?= $rItem->getImageSrc(); ?>" class="img-thumbnail">
                                                <?= \Yii::$app->formatter->asInteger($rItem->getQuantity() * $iOre->getQuantity()); ?>
                                                <br/>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-right"></td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    </div>

                    <div class="col-md-6 col-lg-6">

                        <table class="table talbe-hover">
                            <?php foreach ($m->getOresCollection()->getItems() as $item): ?>
                                <tr>
                                    <td>
                                        <img class="img-thumbnail" src="<?= $item->getImageSrc(); ?>"/> <?= $item->typeName; ?>
                                    </td>
                                    <td><?= $item->getQuantity(); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                        <table class="table table-hover">
                            <?php foreach ($m->getOresCollection()->reprocess(84)->getItems() as $item): ?>
                                <tr>
                                    <td>
                                        <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail"> <?= $item->typeName; ?>
                                    </td>

                                    <td>
                                        <?= \Yii::$app->formatter->asInteger($m->getMineralsCollection()->getItem($item->typeID)->getQuantity()); ?>
                                        -
                                        <?= \Yii::$app->formatter->asInteger($item->getQuantity()); ?>
                                        <br/>
                                        =

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

*/ ?>
</div>
