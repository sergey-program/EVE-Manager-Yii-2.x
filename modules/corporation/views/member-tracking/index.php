<?php

use app\models\CorporationMember;
use app\models\User;
use yii\helpers\Url;

/**
 * @var $this    \app\components\ViewExtended
 * @var $members CorporationMember[]|null
 */
?>

<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Members:</h3>
        </div>

        <div class="box-body">
            <?php if ($members): ?>
                <ul class="list-group">
                    <?php foreach ($members as $member): ?>
                        <?php $hasApi = User::find()->joinWith('token')->where(['AND', ['is not', '_user_token.accessToken', null], ['_user.characterID' => $member->characterID]])->count(); ?>

                        <li class="list-group-item <?= $hasApi ? 'list-group-item-success' : 'list-group-item-warning'; ?>">
                            <img src="https://image.eveonline.com/Character/<?= $member['characterID']; ?>_32.jpg" class="img-thumbnail">
                            <?= $member->characterName; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="alert alert-danger">No data updated.</p>
            <?php endif; ?>
        </div>

        <div class="box-footer text-center">
            <a href="<?= Url::to(['update']); ?>" class="btn btn-primary">Update list</a>
            <a href="<?= Url::to(['delete-all']); ?>" class="btn btn-danger">Delete all</a>
        </div>
    </div>
</div>

<div class="col-md-6">
</div>