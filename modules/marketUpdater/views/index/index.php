<?php

/**
 * @var app\components\ViewExtended  $this
 * @var \app\models\dump\InvTypes[]  $invTypes
 * @var \app\models\dump\InvGroups[] $groups
 */

?>

<div class="row">
    <?php foreach ($groups as $group): ?>

        <div class="col-md-6 col-lg-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="pull-right">
                        <?php $time = $group->marketUpdateGroup->timeUpdate ?? null; ?>
                        <small class="text-muted"><?= \Yii::$app->formatter->asDatetime($time, 'Y-m-d HH:i:s'); ?></small>
                        <a href="<?= \yii\helpers\Url::to(['index/update-group', 'groupID' => $group->groupID]); ?>">Обновить</a>
                    </div>
                    <h3 class="box-title"><?= $group->groupName; ?></h3>
                </div>

                <div class="box-body">
                    <table class="table-bordered table table-hover">
                        <?php foreach ($group->invTypes as $invType): ?>
                            <tr>
                                <td title="<?= $invType->typeID; ?>">
                                    <img src="https://image.eveonline.com/Type/<?= $invType->typeID; ?>_32.png" class="img-thumbnail" style="margin-right: 10px;">
                                    <?= $invType->typeName; ?>
                                </td>
                                <td class="text-right">
                                    <?php $sellPrice = $invType->marketPrice ? $invType->marketPrice->sell : null; ?>
                                    <?= \Yii::$app->formatter->asDecimal($sellPrice); ?>
                                    <br/>

                                    <?php $buyPrice = $invType->marketPrice ? $invType->marketPrice->buy : null; ?>
                                    <?= \Yii::$app->formatter->asDecimal($buyPrice); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>

