<?php

/**
 * @var \app\components\ViewExtended    $this
 * @var \app\components\items\Blueprint $blueprint
 * @var \app\components\items\Item      $prevItem
 */

?>

<div class="col-md-6 col-lg-6">
    <?= \yii\helpers\Html::beginForm(\yii\helpers\Url::to(['settings/update', 'typeID' => $blueprint->typeID]), 'post', ['class' => 'form']); ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="pull-right">
                <a href="<?= \yii\helpers\Url::to(['index/view', 'typeID' => $blueprint->getProduce()->typeID]); ?>">
                    <img src="<?= $blueprint->getProduce()->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;" title="<?= $blueprint->getProduce()->typeName; ?>">
                </a>
            </div>

            <h3 class="box-title">
                <img src="<?= $blueprint->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;">
                <?= $blueprint->typeName; ?>
                <small class="text-muted"><?= $blueprint->typeID; ?></small>
            </h3>
        </div>

        <div class="box-body">

            <table class="table table-hover">
                <tr>
                    <td>
                        Material Efficiency
                        <br/>
                        <small class="text-muted">от 0 до 10</small>
                    </td>
                    <td><input class="form-control" name="<?= $blueprint->typeID; ?>[me]" placeholder="<?= \Yii::$app->formatter->asInteger($blueprint->getSettings()->me); ?>"></td>
                </tr>

                <tr>
                    <td>
                        Material Efficiency (Hull)
                        <br/>
                        <small class="text-muted">от 0 до 3</small>
                    </td>
                    <td><input class="form-control" name="<?= $blueprint->typeID; ?>[meHull]" placeholder="<?= \Yii::$app->formatter->asInteger($blueprint->getSettings()->meHull); ?>"></td>
                </tr>

                <tr>
                    <td>
                        Material Efficiency (Rig)
                        <br/>
                        <small class="text-muted">от 0 до 4.2</small>
                    </td>
                    <td><input class="form-control" name="<?= $blueprint->typeID; ?>[meRig]" placeholder="<?= \Yii::$app->formatter->asDecimal($blueprint->getSettings()->meRig); ?>"></td>
                </tr>

                <tr>
                    <td>Time Efficiency</td>
                    <td><input class="form-control" name="<?= $blueprint->typeID; ?>[te]" placeholder="<?= \Yii::$app->formatter->asInteger($blueprint->getSettings()->te); ?>"></td>
                </tr>

                <tr>
                    <td>Time Efficiency (Hull)</td>
                    <td><input class="form-control" name="<?= $blueprint->typeID; ?>[teHull]" placeholder="<?= \Yii::$app->formatter->asInteger($blueprint->getSettings()->teHull); ?>"></td>
                </tr>


                <tr>
                    <td>Time Efficiency (Rig)</td>
                    <td><input class="form-control" name="<?= $blueprint->typeID; ?>[teRig]" placeholder="<?= \Yii::$app->formatter->asDecimal($blueprint->getSettings()->teRig); ?>"></td>
                </tr>

                <tr>
                    <td>
                        Price per one run (bpc)
                        <br/>
                        <small class="text-muted">количество в исках</small>
                    </td>
                    <td><input class="form-control" name="<?= $blueprint->typeID; ?>[runPrice]" placeholder="<?= \Yii::$app->formatter->asInteger($blueprint->getSettings()->runPrice); ?>"></td>
                </tr>
            </table>

        </div>

        <div class="box-footer text-right">
            <?= \yii\helpers\Html::submitButton('Применить', ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <?= \yii\helpers\Html::endForm(); ?>
</div>

<?php if ($prevItem): ?>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Return back to</h3>
            </div>

            <div class="box-body">
                <a href="<?= \yii\helpers\Url::to(['index/view', 'typeID' => $prevItem->typeID]); ?>">
                    <img src="<?= $prevItem->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;" title="<?= $prevItem->typeName; ?>">
                    <a href="<?= \yii\helpers\Url::to(['index/view', 'typeID' => $prevItem->typeID]); ?>"><?= $prevItem->typeName; ?></a>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

