<?php

namespace app\controllers\_extend;

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
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    ['actions' => ['logout'], 'allow' => true, 'roles' => ['@']],
                ],
            ]
        ];
    }

    /**
     * @return bool
     */
    public function isAjaxRequest()
    {
        return \Yii::$app->getRequest()->getIsAjax();
    }

    /**
     * @return bool
     */
    public function isPostRequest()
    {
        return \Yii::$app->getRequest()->getIsPost();
    }

    /**
     * Return $_POST data.
     *
     * @param string|null $sVarName
     * @param string|null $sDefaultValue
     *
     * @return array|mixed
     */

    public function getPostData($sVarName = null, $sDefaultValue = null)
    {
        return \Yii::$app->getRequest()->post($sVarName, $sDefaultValue);
    }

    /**
     * Return $_GET data.
     *
     * @param string|null $sVarName
     * @param string|null $sDefaultValue
     *
     * @return array|mixed
     */
    public function getGetData($sVarName = null, $sDefaultValue = null)
    {
        return \Yii::$app->getRequest()->get($sVarName, $sDefaultValue);
    }

    /**
     * @param string $sKey
     * @param string $sValue
     *
     * @return $this
     */
    public function setFlash($sKey, $sValue)
    {
        \Yii::$app->getSession()->setFlash($sKey, $sValue);

        return $this;
    }
}