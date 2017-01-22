<?php

use app\assets\AppAsset;
use app\components\ViewExtended;
use app\models\Corporation;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

/**
 * @var app\components\ViewExtended $this
 * @var string                      $content
 */
?>

<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="<?= \Yii::$app->language; ?>">

<head>
    <title><?= Html::encode($this->title); ?></title>

    <meta charset="<?= \Yii::$app->charset; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php /* <link rel="shortcut icon" href="<?= Yii::$app->getRequest()->getBaseUrl(); ?>/favicon.ico" type="image/x-icon"/> */ ?>
    <?= Html::csrfMetaTags(); ?>
    <?php $this->head(); ?>
</head>

<body>
<?php $this->beginBody(); ?>

<div class="wrap">
    <?php NavBar::begin(['brandLabel' => \Yii::$app->name, 'brandUrl' => \Yii::$app->homeUrl, 'options' => ['class' => 'navbar-inverse navbar-fixed-top']]); ?>

    <?= Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Install Corporation', 'url' => ['/corporation/install/index'], 'visible' => Corporation::checkCanInstall(false)],
            ['label' => 'Members', 'url' => ['/corporation/members/index'], 'visible' => !Corporation::checkCanInstall(false)],
            ['label' => 'Calculator', 'url' => ['/calculator/index']],
            \Yii::$app->user->isGuest
                ? ['label' => 'Sign In', 'url' => Url::to(['/auth/sign-in'])]
                : ['label' => 'Sign Out (' . \Yii::$app->user->characterName . ')', 'url' => ['/auth/sign-out']],

        ],
    ]);
    ?>

    <?php NavBar::end(); ?>

    <div class="container">
        <?php if (isset($this->blocks[ViewExtended::PARAM_NAME_BREAD])): ?>
            <?= $this->blocks[ViewExtended::PARAM_NAME_BREAD]; ?>
        <?php endif; ?>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= \Yii::powered(); ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>

