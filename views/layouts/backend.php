<?php
use app\components\ViewExtended;
use yii\widgets\Breadcrumbs;

?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?php if ($this->hasBread()): ?>
    <?php $this->beginBlock(ViewExtended::PARAM_NAME_BREAD); ?>
    <?= Breadcrumbs::widget(['links' => $this->getBread()]) ?>
    <?php $this->endBlock(); ?>
<?php endif; ?>

<?= $content; ?>

<?php $this->endContent(); ?>