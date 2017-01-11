<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
use app\models\UserToken;

class TestController extends AbstractController
{
    public function actionIndex()
    {
        $userToken = UserToken::findOne(4);
        $userToken->refreshAccessToken();
    }
}