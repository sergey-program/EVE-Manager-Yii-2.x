<?php

/**
 * @var \app\components\ViewExtended $this
 * @var \app\components\items\Item   $item
 * @var \app\components\items\Item   $bpo
 */

?>

<?php if ($item->hasBlueprint()): ?>
    <div class="col-md-6 col-lg-6">
        <?= \yii\helpers\Html::beginForm(\yii\helpers\Url::to(['settings/update', 'typeID' => $item->getBlueprint()->typeID]), 'post', ['class' => 'form']); ?>

        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="pull-right">
                    <a href="<?= \yii\helpers\Url::to(['index/view', 'typeID' => $item->typeID]); ?>">
                        <img src="<?= $item->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;" title="<?= $item->typeName; ?>">
                    </a>
                </div>

                <h3 class="box-title">
                    <img src="<?= $bpo->getImageSrc(); ?>" class="img-thumbnail" style="margin-right: 10px;">
                    <?= $bpo->typeName; ?>
                    <small class="text-muted"><?= $bpo->typeID; ?></small>
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
                        <td><input class="form-control" name="<?= $bpo->typeID; ?>[me]" placeholder="<?= \Yii::$app->formatter->asInteger($bpo->getSettings()->me); ?>"></td>
                    </tr>

                    <tr>
                        <td>
                            Material Efficiency (Hull)
                            <br/>
                            <small class="text-muted">от 0 до 3</small>
                        </td>
                        <td><input class="form-control" name="<?= $bpo->typeID; ?>[meHull]" placeholder="<?= \Yii::$app->formatter->asInteger($bpo->getSettings()->meHull); ?>"></td>
                    </tr>

                    <tr>
                        <td>
                            Material Efficiency (Rig)
                            <br/>
                            <small class="text-muted">от 0 до 4.2</small>
                        </td>
                        <td><input class="form-control" name="<?= $bpo->typeID; ?>[meRig]" placeholder="<?= \Yii::$app->formatter->asDecimal($bpo->getSettings()->meRig); ?>"></td>
                    </tr>

                    <tr>
                        <td>Time Efficiency</td>
                        <td><input class="form-control" name="<?= $bpo->typeID; ?>[te]" placeholder="<?= \Yii::$app->formatter->asInteger($bpo->getSettings()->te); ?>"></td>
                    </tr>

                    <tr>
                        <td>Time Efficiency (Hull)</td>
                        <td><input class="form-control" name="<?= $bpo->typeID; ?>[teHull]" placeholder="<?= \Yii::$app->formatter->asInteger($bpo->getSettings()->teHull); ?>"></td>
                    </tr>


                    <tr>
                        <td>Time Efficiency (Rig)</td>
                        <td><input class="form-control" name="<?= $bpo->typeID; ?>[teRig]" placeholder="<?= \Yii::$app->formatter->asDecimal($bpo->getSettings()->teRig); ?>"></td>
                    </tr>

                    <tr>
                        <td>
                            Price per one run (bpc)
                            <br/>
                            <small class="text-muted">количество в исках</small>
                        </td>
                        <td><input class="form-control" name="<?= $bpo->typeID; ?>[runPrice]" placeholder="<?= \Yii::$app->formatter->asInteger($bpo->getSettings()->runPrice); ?>"></td>
                    </tr>
                </table>

            </div>

            <div class="box-footer text-right">
                <?= \yii\helpers\Html::submitButton('Применить', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
        <?= \yii\helpers\Html::endForm(); ?>
    </div>
<?php endif; ?>