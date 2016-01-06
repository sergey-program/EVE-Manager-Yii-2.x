<?php

namespace app\controllers\extend;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class AbstractController
 *
 * @package app\controllers\_extend
 */
abstract class AbstractController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'roles' => ['user']],         // all others user
                    ['allow' => true, 'controllers' => ['auth']]    // allow only authentication
                ]
            ]
        ];
    }

    /**
     * @return \app\components\ViewExtended
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return \Yii::$app->request->isAjax;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return \Yii::$app->request->isPost;
    }

    /**
     * @param string|null $varName
     * @param string|null $defaultValue
     *
     * @return array|string
     */

    public function post($varName = null, $defaultValue = null)
    {
        return \Yii::$app->request->post($varName, $defaultValue);
    }

    /**
     * @param string|null $varName
     * @param string|null $defaultValue
     *
     * @return array|string
     */
    public function get($varName = null, $defaultValue = null)
    {
        return \Yii::$app->request->get($varName, $defaultValue);
    }
}