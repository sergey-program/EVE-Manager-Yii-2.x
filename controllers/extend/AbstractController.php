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
     * Redefine return class for autocomplete (IDE).
     *
     * @return \app\components\ViewExtended
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * Simple wrapper.
     *
     * @param string|null $varName
     * @param string|null $defaultValue
     *
     * @return array|string
     */

    public function getPost($varName = null, $defaultValue = null)
    {
        return \Yii::$app->request->post($varName, $defaultValue);
    }

    /**
     * Simple wrapper.
     *
     * @param string|null $varName
     * @param string|null $defaultValue
     *
     * @return array|string
     */
    public function getGet($varName = null, $defaultValue = null)
    {
        return \Yii::$app->request->get($varName, $defaultValue);
    }
}