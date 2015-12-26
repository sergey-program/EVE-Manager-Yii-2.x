<?php

namespace app\modules\station\controllers;

use app\calls\eve\CallConquerableStation;
use app\modules\station\controllers\extend\AbstractStationController;
use app\modules\station\models\SearchConquerableStation;
use app\modules\station\updaters\UpdaterEveConquerableStation;
use yii\helpers\Url;

/**
 * Class IndexController
 *
 * @package app\modules\station\controllers
 */
class IndexController extends AbstractStationController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);

        $this
            ->getView()
            ->addBread(['label' => 'Index']);

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionList()
    {
        Url::remember(Url::current(), self::REMEMBER_NAME);

        $this
            ->getView()
            ->addBread(['label' => 'List']);

        return $this->render('list', ['searchConquerableStation' => new SearchConquerableStation()]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionUpdate()
    {
        $callConquerableStation = new CallConquerableStation();
        $callConquerableStation->update();

        return $this->redirect(Url::previous('station'));
    }
}