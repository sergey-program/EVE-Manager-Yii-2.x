<?php

use yii\helpers\Url;

/**
 * @var app\components\ViewExtended  $this
 * @var \app\models\dump\InvTypes[]  $invTypes
 * @var \app\models\dump\InvGroups[] $groups
 */

?>

<div class="row">
    <?php foreach ($groups as $group): ?>

        <div class="col-md-8">
            <div class="panel box box-primary">
                <div class="box-header with-border">
                    <div class="pull-right">
                        <a href="<?= Url::to(['index/update-group', 'groupID' => $group->groupID]); ?>" title="Update"><i class="fa fa-fw fa-repeat"></i> </a>

                        <?php $time = $group->marketUpdateGroup->timeUpdate ?? null; ?>
                        <small class="text-muted" style="margin-right: 10px; margin-left: 5px;"><?= \Yii::$app->formatter->asDatetime($time, 'Y-MM-dd HH:mm:ss VV'); ?></small>

                        <input name="some1" class="jsAutoUpdate" type="checkbox">
                    </div>

                    <a data-toggle="collapse" href="#collapse<?= $group->groupID; ?>">
                        <h3 class="box-title"><?= $group->groupName; ?></h3>
                    </a>
                </div>

                <div id="collapse<?= $group->groupID; ?>" class="panel-collapse collapse">
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
        </div>

    <?php endforeach; ?>
</div>

