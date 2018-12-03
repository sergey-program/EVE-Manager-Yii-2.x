<?php

// this file used for autocomplete, and should not be executed at all

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property \app\components\RbacManager $authManager The auth manager for this application. Null is returned if auth manager is not configured. This property is read-only. Extended component.
 * @property \app\components\Mailer      $mailer      The mailer component. This property is read-only. Extended component.
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property \app\components\User                      $user         The user component. This property is read-only. Extended component.
 * @property \app\components\MyResponse                $response     The response component. This property is read-only. Extended component.
 * @property \app\components\ErrorHandler              $errorHandler The error handler application component. This property is read-only. Extended component.
 * @property \app\components\actions\ActionUpdatePrice $actionUpdatePrice
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 * @property \app\components\ConsoleUser $user The user component. This property is read-only. Extended component.
 */
class ConsoleApplication extends yii\console\Application
{
}