<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;
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
    private $defaultName;
    private $defaultMessage;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->defaultName = 'Error';
        $this->defaultMessage = 'An internal server error occurred.';
    }

    /**
     * Copied from 'yii\web\ErrorAction'
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->getView()->setTitle('Error');

        if (!YII_ENV_PROD) {
            $exception = \Yii::$app->errorHandler->exception;

            if ($exception === null) {
                return '';
            }

            if ($exception instanceof HttpException) {
                $code = $exception->statusCode;
            } else {
                $code = $exception->getCode();
            }

            if ($exception instanceof Exception) {
                $name = $exception->getName();
            } else {
                $name = $this->defaultName;
            }

            if ($exception instanceof UserException) {
                $message = $exception->getMessage();
            } else {
                $message = $this->defaultMessage;
            }

            $name .= ($code) ? ' (#' . $code . ')' : '';

            if ($this->isAjax()) {
                return $name . ':' . $message;
            }

            return $this->render('index', [
                'name' => $name,
                'message' => $message,
                'exception' => $exception
            ]);
        }

        return 'Error.';
    }
}