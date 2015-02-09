<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\ViewExtended;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link rel="shortcut icon" href="<?= Yii::$app->getRequest()->getBaseUrl(); ?>/favicon.ico" type="image/x-icon"/>
    </head>

    <body>

    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->getHomeUrl(),
            'options' => ['class' => 'navbar-inverse navbar-fixed-top']
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Home', 'url' => Yii::$app->getHomeUrl()],
                ['label' => 'About', 'url' => ['/about']],
                ['label' => 'Contact', 'url' => ['/contact']],
                ['label' => 'Api', 'url' => ['/api/index/index']],
                ['label' => 'Characters', 'url' => ['/characters/index/index']],
                ['label' => 'Station', 'url' => ['/station/index/index']],
                Yii::$app->user->isGuest ?
                    ['label' => 'Login', 'url' => ['/auth/login']] :
                    [
                        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/auth/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ],
            ],
        ]);
        NavBar::end();
        ?>

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
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>

    </html>

<?php $this->endPage() ?>