<?php

namespace app\controllers;

use app\controllers\_extend\AbstractController;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;

/**
 * Class ErrorController
 *
 * @package app\controllers
 */
class ErrorController extends AbstractController
{
    private $_sDefaultName;
    private $_sDefaultMessage;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->_sDefaultName = 'Error';
        $this->_sDefaultMessage = 'An internal server error occurred.';
    }

    /**
     * Copied from 'yii\web\ErrorAction'
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!YII_ENV_PROD) {
            $oException = \Yii::$app->getErrorHandler()->exception;

            if ($oException === null) {
                return '';
            }

            if ($oException instanceof HttpException) {
                $sCode = $oException->statusCode;
            } else {
                $sCode = $oException->getCode();
            }

            if ($oException instanceof Exception) {
                $sName = $oException->getName();
            } else {
                $sName = $this->_sDefaultName;
            }

            if ($oException instanceof UserException) {
                $sMessage = $oException->getMessage();
            } else {
                $sMessage = $this->_sDefaultMessage;
            }

            $sName .= ($sCode) ? ' (#' . $sCode . ')' : '';

            if ($this->isAjaxRequest()) {
                return $sName . ':' . $sMessage;
            }

            return $this->render('index', ['name' => $sName, 'message' => $sMessage, 'exception' => $oException]);
        }
    }
}