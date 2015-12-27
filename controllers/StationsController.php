<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
use app\calls\eve\CallConquerableStation;
use app\models\SearchConquerableStation;
use yii\helpers\Url;

/**
 * Class IndexController
 *
 * @package app\modules\station\controllers
 */
class StationsController extends AbstractController
{
    public $defaultAction = 'list';
    public $layout = 'backend';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->getView()->addBread([
            'label' => 'Station',
            'url' => '/station'
        ]);
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $this->getView()->addBread('List');

        return $this->render('list', ['searchConquerableStation' => new SearchConquerableStation()]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionUpdate()
    {
        $callConquerableStation = new CallConquerableStation();
        $callConquerableStation->update();

        return $this->redirect(['/stations']);
    }
}