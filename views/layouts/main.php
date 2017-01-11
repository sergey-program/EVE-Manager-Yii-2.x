<?php

use app\assets\AppAsset;
use app\components\ViewExtended;
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
            ['label' => 'Home', 'url' => Yii::$app->getHomeUrl()],

            ['label' => 'About', 'url' => ['/about/index']],
            ['label' => 'Api', 'url' => ['/api']],
            ['label' => 'Characters', 'url' => ['/characters']],
            ['label' => 'Station', 'url' => ['/stations']],
            ['label' => 'Prices', 'url' => ['/prices/index/index']],
            \Yii::$app->user->isGuest ?
                ['label' => 'Sign In', 'url' => Url::to(['/auth/sign-in'])] :
                [
                    'label' => 'Sign Out (' . \Yii::$app->user->identity->characterName . ')',
                    'url' => ['/auth/sign-out']

                ],
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

