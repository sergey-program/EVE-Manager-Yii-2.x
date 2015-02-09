<?php

namespace app\modules\api\controllers\_extend;

use app\controllers\_extend\AbstractController;
use app\models\Api;

abstract class ApiController extends AbstractController
{
    public $layout = 'main';
    public $mApi;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->addBread(['label' => 'Api', 'url' => ['/api/index/index']]);
        $iApiID = $this->getGetData('apiID');

        if ($iApiID) {
            $this->mApi = Api::findOne(['id' => $iApiID]);
        }
    }
}