<?php

namespace app\modules\api\controllers\extend;

use app\controllers\extend\AbstractController;
use app\models\Api;
use yii\web\NotFoundHttpException;

/**
 * Class AbstractApiController
 *
 * @package app\modules\api\controllers\extend
 */
abstract class AbstractApiController extends AbstractController
{
    const REMEMBER_NAME = 'api';

    public $layout = 'main';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this
            ->getView()
            ->addBread(['label' => 'Api', 'url' => ['index/index']]);
    }

    /**
     * @param int $id
     *
     * @return Api
     * @throws NotFoundHttpException
     */
    protected function loadApi($id)
    {
        /** @var Api $model */
        $model = Api::find()->where(['id' => $id, 'userID' => \Yii::$app->user->id])->one();

        if (!$model) {
            throw new NotFoundHttpException('Api not found.');
        }

        return $model;
    }
}