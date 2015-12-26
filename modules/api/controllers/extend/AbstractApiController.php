<?php

namespace app\modules\api\controllers\extend;

use app\controllers\_extend\AbstractController;
use app\models\Api;

/**
 * Class AbstractApiController
 *
 * @package app\modules\api\controllers\extend
 */
abstract class AbstractApiController extends AbstractController
{
    public $layout = 'main';
    public $api;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->addBread(['label' => 'Api', 'url' => ['/api/index/index']]);

        $apiID = $this->getGetData('apiID');

        if ($apiID) {
            $this->api = Api::findOne(['id' => $apiID]);
        }
    }
}