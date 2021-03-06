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
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['allow' => true, 'roles' => ['@']]
                ]
            ]
        ];
    }

    /**
     * Redefine return class for auto-complete (IDE).
     *
     * @return \app\components\ViewExtended|\yii\base\View|\yii\web\View
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

    public function post($varName = null, $defaultValue = null)
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
    public function get($varName = null, $defaultValue = null)
    {
        return \Yii::$app->request->get($varName, $defaultValue);
    }
}