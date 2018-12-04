<?php

/**
 * @var \app\components\ViewExtended $this
 * @var \app\components\items\Item[] $items
 * @var \app\components\items\Item[] $lastItems
 */

?>

<div class="row">

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Search item</h3>
            </div>

            <div class="box-body">
                <?= \yii\helpers\Html::beginForm(\yii\helpers\Url::to('index'), 'get'); ?>

                <div class="form-group">
                    <input type="text" name="query" placeholder="partial string" class="form-control">
                </div>

                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Найти', ['class' => 'btn btn-primary']); ?>
                </div>

                <?= \yii\helpers\Html::endForm(); ?>

                <table class="table">
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail invType" alt="<?= $item->typeName; ?>">
                                <a href="<?= \yii\helpers\Url::to(['index/view', 'typeID' => $item->typeID]); ?>"> <?= $item->typeName; ?></a>
                                <small class="text-muted"><?= $item->typeID; ?></small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <?php if (!empty($lastItems)): ?>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Last viewed items</h3>
                </div>

                <div class="box-body">
                    <table class="table">
                        <?php foreach ($lastItems as $lastItem): ?>
                            <tr>
                                <td>
                                    <img src="<?= $lastItem->getImageSrc(); ?>" class="img-thumbnail invType" alt="<?= $lastItem->typeName; ?>">
                                    <a href="<?= \yii\helpers\Url::to(['index/view', 'typeID' => $lastItem->typeID]); ?>"> <?= $lastItem->typeName; ?></a>
                                    <small class="text-muted"><?= $lastItem->typeID; ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
