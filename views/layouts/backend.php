<?php

use app\components\ViewExtended;
use yii\widgets\Breadcrumbs;

/**
 * @var app\components\ViewExtended $this
 * @var string                      $content
 */
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?php if ($this->hasBreads()): ?>
    <?php $this->beginBlock(ViewExtended::PARAM_NAME_BREAD); ?>
    <?= Breadcrumbs::widget(['links' => $this->getBreads()]) ?>
    <?php $this->endBlock(); ?>
<?php endif; ?>

<?= $content; ?>

<?php $this->endContent(); ?>