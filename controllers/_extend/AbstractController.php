<?php

namespace app\controllers\_extend;

use yii\web\Controller;

/**
 * Class AbstractController
 *
 * @package app\controllers\_extend
 */
abstract class AbstractController extends Controller
{
    /**
     * Simple wrapper for ViewExtended class ->addBread().
     *
     * @param string|array $data
     *
     * @return $this
     */
    public function addBread($data)
    {
        $this->getView()->addBread($data);

        return $this;
    }

    /**
     * Simple wrapper for ViewExtended class ->setTitle().
     *
     * @param string $sTitle
     *
     * @return $this
     */
    public function setTitle($sTitle)
    {
        $this->getView()->setTitle($sTitle);

        return $this;
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