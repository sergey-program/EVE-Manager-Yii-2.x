<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo Yii::app()->name; ?> :: <?php echo $this->sTitle; ?></title>

    <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.theme.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.fix.css" media="screen, projection"/>

    <script type="text/javascript" src="/public/js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="/public/js/select2-3.4.8/select2.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/js/select2-3.4.8/select2.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/public/js/select2-3.4.8/select2-bootstrap.css" media="screen, projection"/>
</head>

<body>

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Yii::app()->homeUrl; ?>"><?php echo Yii::app()->name; ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">Some page</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Api <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo Yii::app()->createUrl('api/add'); ?>">Add</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('api/list'); ?>">List</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Character(s) <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo Yii::app()->createUrl('character/list'); ?>">Show All</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Some link</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Update All <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo Yii::app()->createUrl('market/order/update'); ?>">Orders</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('cnqStation/update'); ?>">Conquerable Station List</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- navbar-collapse -->
    </div>
    <!-- container -->
</nav>
<?php $this->widget('wFlashMessage'); ?>
<?php echo $content; ?>

</body>

</html>