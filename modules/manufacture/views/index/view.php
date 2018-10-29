<?php

/**
 * @var \app\components\ViewExtended $this
 * @var \app\components\items\Item   $item
 */

?>
<style>
    .img-thumbnail-hand {
        cursor: pointer;
    }
</style>

<div class="row">

    <div class="col-md-6 col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">

                <div class="pull-right">
                    <?= $item->getBlueprint()->getSettings()->me; ?> / <?= $item->getBlueprint()->getSettings()->meHull; ?> / <?= $item->getBlueprint()->getSettings()->meRig; ?>

                    <a href="<?= \yii\helpers\Url::to(['settings/update', 'typeID' => $item->typeID]); ?>" title="Update bpo settings">
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
                    <?php foreach ($item->getBlueprint()->getMaterials() as $mItem): ?>
                        <?= $this->render('_row', ['mItem' => $mItem, 'p' => 0]); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text text-warning">Item has not blueprint.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
    /** @var \app\modules\calculators\components\MineralComponent $mao */
    /*
    $mao = \Yii::$app->mineralAsOre;
    $itemRequiredCollection = new \app\components\items\ItemRequiredCollection();
    $mTotal = \app\modules\manufacture\components\MManager::calculateTotal($mItem);
    $itemRequiredCollection->parseTotal($mTotal);
    */
    ?>

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
                                <?= \Yii::$app->formatter->asInteger(0/*$mTotal->getPriceBlueprintRuns()*/); ?>
                            </td>
                        </tr>

                    </table>

                </div>
            </div>
        </form>
    </div>

    <?php // $mao->setItemRequiredCollection($itemRequiredCollection); ?>

    <div class="col-md-6">
        <div class="panel box">
            <div class="box-body">
                <table class="table">
                    <?php /*
                    <?php $mao->calculate(); ?>
                    <?php foreach ($mao->primaryOre as $mineralTypeID => $oreTypeID): ?>
                        <?php $mineralType = \app\models\dump\InvTypes::findOne(['typeID' => $mineralTypeID]); ?>
                        <?php $oreType = \app\models\dump\InvTypes::findOne(['typeID' => $oreTypeID]); ?>
                        <tr>
                            <td style="width: 75px;">
                                <img src="https://image.eveonline.com/Type/<?= $mineralTypeID; ?>_32.png" class="img-thumbnail">
                            </td>

                            <td>
                                <?= \Yii::$app->formatter->asText($mineralType->typeName); ?>
                                <small class="text-muted"><?= $mineralTypeID; ?></small>
                                <br/>
                                <?= \Yii::$app->formatter->asInteger($itemRequiredCollection->getQuantity($mineralTypeID)); ?>
                            </td>

                            <td style="width: 100px;">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= $oreType->typeName ?? 'null'; ?> <span class="caret" style="margin-left: 5px;"></span>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <?php foreach (\Yii::$app->selectorOres->getCompressed($mineralTypeID) as $i): ?>
                                            <li><a href="<?= \yii\helpers\Url::to(['index/set-ore', 'typeID' => \Yii::$app->request->get('typeID'), 'mineralTypeID' => $mineralTypeID, 'oreTypeID' => $i->typeID]); ?>"><?= $i->typeName; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                        <li><a href="<?= \yii\helpers\Url::to(['index/set-ore', 'typeID' => \Yii::$app->request->get('typeID'), 'mineralTypeID' => $mineralTypeID, 'oreTypeID' => null]); ?>">Clear</a></li>
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
                                <?php if ($oreTypeID): ?>
                                    <img src="https://image.eveonline.com/Type/<?= $oreTypeID; ?>_32.png" class="img-thumbnail">
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($oreTypeID): ?>
                                    <?= \Yii::$app->formatter->asText($oreType->typeName); ?>
                                    <small class="text-muted"><?= $oreTypeID; ?></small>
                                    <br/>
                                    <?php foreach ($mao->result as $typeID => $itemResult): ?>
                                        <?php if ($itemResult->invType->typeID == $oreTypeID): ?>
                                            <?= \Yii::$app->formatter->asInteger($itemResult->getQuantity()); ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>

                            <td class="text-right">
                                <?php if ($oreTypeID): ?>
                                    <?php foreach ($mao->result as $typeID => $itemResult): ?>
                                        <?php if ($itemResult->invType->typeID == $oreTypeID): ?>
                                            <?php foreach ($itemResult->items as $item): ?>
                                                <img src="https://image.eveonline.com/Type/<?= $item->invType->typeID; ?>_32.png" class="img-thumbnail">
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
 */ ?>
                </table>

                <table class="table">
                    <tr>
                        <td colspan="2">------</td>
                    </tr>

                    <?php /* foreach ($mao->result as $typeID => $itemResult): ?>
                        <tr>
                            <td>
                                <img src="https://image.eveonline.com/Type/<?= $itemResult->invType->typeID; ?>_32.png" class="img-thumbnail">
                                <?= \Yii::$app->formatter->asInteger($itemResult->quantity); ?>
                            </td>
                            <td>
                                <table class="table">
                                    <?php foreach ($itemResult->items as $itemResultChild): ?>
                                        <tr>
                                            <td>
                                                <img src="https://image.eveonline.com/Type/<?= $itemResultChild->invType->typeID; ?>_32.png" class="img-thumbnail">
                                                <?= $itemResultChild->invType->typeID; ?>
                                            </td>
                                            <td><?= \Yii::$app->formatter->asInteger($itemResultChild->quantity); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; */ ?>

                    <?php foreach ([40, 39, 38, 37, 36, 35, 34] as $typeID): ?>
                        <tr>
                            <td>
                                <?php /*
                                <img src="https://image.eveonline.com/Type/<?= $typeID; ?>_32.png" class="img-thumbnail">
                                <?= \Yii::$app->formatter->asInteger($mao->getItemRequiredCollection()->getQuantityTotal($typeID)); ?><br/>
 */ ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>


</div>
