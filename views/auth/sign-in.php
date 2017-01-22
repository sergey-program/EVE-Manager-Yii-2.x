<?php

use app\assets\AppAsset;
use app\components\EveSSO;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this      app\components\ViewExtended
 * @var $signInUrl string
 */

AppAsset::register($this);

?>

<?php $this->beginPage(); ?>

<!DOCTYPE html>
<html lang="<?= \Yii::$app->language; ?>">

<head>
    <meta charset="<?= \Yii::$app->charset; ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= Html::encode($this->title); ?></title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <!--    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/_theme/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/_theme/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?= Html::csrfMetaTags(); ?>
    <?php $this->head(); ?>
</head>


<body class="hold-transition login-page">

<?php $this->beginBody(); ?>

<div class="login-box">
    <div class="login-logo">
        <a href="<?= \Yii::$app->homeUrl; ?>"><?= Url::to(['/'], true); ?></a>
    </div>

    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" method="post">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" disabled>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" disabled>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label><input type="checkbox" disabled> Remember Me</label>
                    </div>
                </div>

                <div class="col-xs-4">
                    <button type="submit" disabled class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="<?= EveSSO::createUrl(EveSSO::ACTION_SI); ?>">
                <img src="https://images.contentful.com/idjq7aai9ylm/4fSjj56uD6CYwYyus4KmES/4f6385c91e6de56274d99496e6adebab/EVE_SSO_Login_Buttons_Large_Black.png?w=270&h=45">
            </a>
        </div>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<!--<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>-->
<!-- Bootstrap 3.3.6 -->
<!--<script src="../../bootstrap/js/bootstrap.min.js"></script>-->
<!-- iCheck -->
<script src="/_theme/plugins/iCheck/icheck.min.js"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

<?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>



