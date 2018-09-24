<?php

/**
 * @var app\components\ViewExtended $this
 * @var \app\models\dump\InvTypes[] $invTypes
 */

?>

<div class="row">
    <div class="col-md-6">
        <?= \yii\helpers\Html::beginForm(); ?>

        <input type="text" name="query" placeholder="partial string">

        <?= \yii\helpers\Html::endForm(); ?>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">result</h3>
            </div>

            <div class="box-body">
                <table class="table">

                    <?php foreach ($invTypes as $invType): ?>
                        <tr>
                            <td>
                                <img src="https://image.eveonline.com/Type/<?= $invType->typeID; ?>_32.png" class="img-thumbnail" style="margin-left: 10px; margin-right: 10px;">
                                <a href="<?= \yii\helpers\Url::to(['index/view', 'typeID' => $invType->typeID]); ?>"><?= $invType->typeName; ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

</div>
