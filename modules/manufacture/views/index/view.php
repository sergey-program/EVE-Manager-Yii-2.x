<?php

/**
 * @var \app\components\ViewExtended $this
 * @var \app\components\items\Item   $item
 */

/** @var \app\components\actions\ActionManufacture $actionManufacture */
$actionManufacture = \Yii::$app->actionManufacture;
/** @var \app\components\actions\ActionRefine $actionRefine */
$actionRefine = \Yii::$app->actionRefine;
/** @var \app\components\items\BlueprintCollection $bCollection */
$bCollection = $actionManufacture->getAllBlueprints($item->getBlueprint());

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
                    <?php foreach ($actionManufacture->calculate($item->getBlueprint())->getItems() as $mItem): ?>
                        <?= $this->render('_row', ['mItem' => $mItem, 'p' => 0]); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text text-warning">Item has not blueprint.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Materials</h3>
            </div>

            <div class="box-body no-padding">
                <table class="table table-striped table-hover">
                    <?php $minerals = $actionManufacture->calculateMinerals($item->getBlueprint()); ?>
                    <?php foreach ($minerals->getItems() as $pItem): ?>
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
                            <?= \Yii::$app->formatter->asDecimal($minerals->getPriceSell()); ?>
                            <br/>
                            <?= \Yii::$app->formatter->asDecimal($minerals->getPriceBuy()); ?>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <form class="form">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Copy prices</h3>
                </div>

                <div class="box-body no-padding">
                    <table class="table table-striped table-hover">
                        <?php foreach ($bCollection->getItems() as $bItem): ?>
                            <tr>
                                <td>
                                    <a href="<?= \yii\helpers\Url::to(['settings/update', 'typeID' => $bItem->typeID]); ?>">
                                        <img src="<?= $bItem->getImageSrc(); ?>" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                                    </a>
                                    <?= $bItem->typeName; ?>
                                    <small class="text-muted"><?= $bItem->typeID; ?></small>
                                </td>

                                <td class="text-right">
                                    <?= \Yii::$app->formatter->asInteger($bItem->getRuns()); ?>
                                </td>

                                <td class="text-right">
                                    <?= \Yii::$app->formatter->asInteger($bItem->getSettings()->runPrice); ?>
                                </td>

                                <td class="text-right">
                                    <?= \Yii::$app->formatter->asInteger($bItem->getSettings()->runPrice * $bItem->getRuns()); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                            <td class="text-right">
                                <?= \Yii::$app->formatter->asInteger($bCollection->getRunPrices()); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <?= $this->render('_block_minerals_in_ore', ['item' => $item]); ?>
</div>
