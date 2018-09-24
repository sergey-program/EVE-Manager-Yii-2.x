<?php

/**
 * @var app\components\ViewExtended               $this
 * @var \app\modules\manufacture\components\MItem $mItem
 */

?>

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
                    <h3 class="box-title">Blueprints settings</h3>
                </div>

                <div class="box-body">
                    <?= $this->render('_rowBpo', ['cItem' => $mItem, 'p' => 20]); ?>
                </div>

                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-primary">Применить</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-6 col-lg-4">
        <form class="form">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Materials total</h3>
                </div>

                <div class="box-body">
                    <?php
                    $mTotal = \app\modules\manufacture\components\MManager::calculateTotal($mItem);
                    $mTotal->loadPrices();
                    ?>

                    <?php $totalPrice = 0; ?>
                    <?php foreach ($mTotal->getItems() as $typeID => $item): ?>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <img src="https://image.eveonline.com/Type/<?= $typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                                <?= number_format($item['quantity'], 0, '.', ' '); ?>
                                *
                                <?= number_format($item['price']->buy, 0, '.', ' '); ?>
                                =
                                <?= number_format($item['quantity'] * $item['price']->buy, 2, '.', ' '); ?>
                            </div>
                        </div>
                        <?php $totalPrice += $item['quantity'] * $item['price']->buy; ?>
                    <?php endforeach; ?>

                    <div class="row">
                        <div class="col-md-12">
                            <p>Total: <?= number_format($totalPrice, 2, '.', ' '); ?> isk</p>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

</div>
