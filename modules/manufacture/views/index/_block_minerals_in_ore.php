<?php

/**
 * @var \app\components\items\Item $item
 */

/** @var \app\components\actions\ActionManufacture $actionManufacture */
$actionManufacture = \Yii::$app->actionManufacture;
/** @var \app\components\actions\ActionRefine $actionRefine */
$actionRefine = \Yii::$app->actionRefine;

?>

<div class="col-md-12">
    <div class="panel box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <table class="table table-hover">

                        <?php
                        $m = new \app\modules\calculators\components\MineralComponent();
                        $mineralCollection = $actionManufacture->calculateMinerals($item->getBlueprint());
                        $m->setCollectionMinerals($mineralCollection);
                        $m->calculate();
                        ?>

                        <?php foreach ($m->getCollectionMinerals()->getItems() as $iItem): ?>
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
                                            <?php $mao = new \app\modules\calculators\components\MineralAsOre(); ?>
                                            <?= $mao->getOreForMineral($iItem->typeID)->typeName ?? 'Not set'; ?> <span class="caret" style="margin-left: 5px;"></span>
                                        </button>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?= \yii\helpers\Url::to(['settings/set-compressed-ore', 'typeID' => \Yii::$app->request->get('typeID'), 'mineralTypeID' => $iItem->typeID, 'oreTypeID' => null]); ?>">
                                                    Clear
                                                </a>
                                            </li>

                                            <?php foreach (\Yii::$app->selectorOres->getCompressed($iItem->typeID) as $i): ?>
                                                <li>
                                                    <a href="<?= \yii\helpers\Url::to(['settings/set-compressed-ore', 'typeID' => \Yii::$app->request->get('typeID'), 'mineralTypeID' => $iItem->typeID, 'oreTypeID' => $i->typeID]); ?>">
                                                        <?= $i->typeName; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                            <?php /*
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        */ ?>
                                        </ul>
                                    </div>

                                    <?php /* <input class="form-control" type="text" name="" value="<?= $oreTypeID; ?>"> */ ?>
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
                                        <?php /* foreach ($iOre->getReprocessResult() as $rItem): ?>
                                                <img src="<?= $rItem->getImageSrc(); ?>" class="img-thumbnail">
                                                <?= \Yii::$app->formatter->asInteger($rItem->getQuantity() * $iOre->getQuantity()); ?>
                                                <br/>
                                            <?php endforeach; */ ?>
                                    <?php endif; ?>
                                </td>

                                <td class="text-right"></td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                </div>

                <div class="col-md-6 col-lg-6">

                    <table class="table talbe-hover">
                        <?php foreach ($m->getCollectionOres()->getItems() as $item): ?>
                            <tr>
                                <td>
                                    <img class="img-thumbnail" src="<?= $item->getImageSrc(); ?>"/> <?= $item->typeName; ?>
                                </td>
                                <td><?= $item->getQuantity(); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <table class="table table-hover">
                        <?php foreach ($actionRefine->runCollection($m->getCollectionOres())->getItems() as $item): ?>
                            <tr>
                                <td>
                                    <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail"> <?= $item->typeName; ?>
                                </td>

                                <td class="text-right">
                                    <?php
                                    $weNeed = $m->getCollectionMinerals()->getItem($item->typeID)->getQuantity();
                                    $weHave = $item->getQuantity();
                                    $result = $weNeed - $weHave;
                                    ?>

                                    <?= \Yii::$app->formatter->asInteger($weNeed); ?>
                                    <br/>
                                    - <?= \Yii::$app->formatter->asInteger($weHave); ?>
                                    <br/>
                                    <span class="<?= ($result > 0) ? 'text-danger' : 'text-success'; ?>">
                                        <?= \Yii::$app->formatter->asInteger(abs($result)); ?>
                                    </span>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
