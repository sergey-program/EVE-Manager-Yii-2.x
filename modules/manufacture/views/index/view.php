<?php

/**
 * @var app\components\ViewExtended               $this
 * @var \app\modules\manufacture\components\MItem $mItem
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
                    <img src="https://image.eveonline.com/Type/<?= $mItem->getBlueprint()->getInvType()->typeID; ?>_32.png"
                         title="<?= $mItem->getBlueprint()->getInvType()->typeName; ?>"
                         class="img-thumbnail"
                         style="margin-left: 10px; margin-right: 10px;">
                </div>

                <h3 class="box-title">
                    <img src="https://image.eveonline.com/Type/<?= $mItem->getInvType()->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                    <?= $mItem->getInvType()->typeName; ?> (<?= $mItem->getInvType()->typeID; ?>)
                </h3>
            </div>

            <div class="box-body">
                <?php foreach ($mItem->getBlueprint()->getItems() as $cItem): ?>
                    <?= $this->render('_row', ['cItem' => $cItem, 'p' => 0]); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <form class="form">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Materials</h3>
                </div>

                <div class="box-body no-padding">
                    <?php $mTotal = \app\modules\manufacture\components\MManager::calculateTotal($mItem); ?>

                    <table class="table table-striped table-hover">
                        <?php foreach ($mTotal->getItems() as $typeID => $pItem): ?>
                            <tr>
                                <td>
                                    <div>
                                        <img src="https://image.eveonline.com/Type/<?= $typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                                        <?= number_format($pItem->getQuantity(), 0, '.', ' '); ?>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceSell(null)); ?>
                                    <br/>
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceBuy(null)); ?>
                                </td>
                                <td class="text-right">
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceSellTotal(null)); ?>
                                    <br/>
                                    <?= \Yii::$app->formatter->asDecimal($pItem->getPriceBuyTotal(null)); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td class="text-right">
                                <?= \Yii::$app->formatter->asDecimal($mTotal->getPriceSellTotal()); ?>
                                <br/>
                                <?= \Yii::$app->formatter->asDecimal($mTotal->getPriceBuyTotal()); ?>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </form>
    </div>

    <div class="col-md-6 col-lg-4">
        <?= \yii\helpers\Html::beginForm('','post', ['class' => 'form form-inline']);?>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Blueprints settings</h3>
                </div>

                <div class="box-body">
                    <?= $this->render('_rowBpo', ['cItem' => $mItem, 'p' => 20]); ?>
                </div>

                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-primary">Применить</button>
                </div>
            </div>
        <?= \yii\helpers\Html::endForm(); ?>
    </div>

</div>
