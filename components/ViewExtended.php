<?php

namespace app\components;

use yii\web\View;

class ViewExtended extends View
{
    const PARAM_NAME_BREAD = 'bread';

    /**
     * Set default page title.
     */
    public function init()
    {
        parent::init();

        $this->setTitle(\Yii::$app->name);
    }

    /**
     * @param string $sPageTitle
     *
     * @return $this
     */
    public function setTitle($sPageTitle)
    {
        $this->title = $sPageTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|array $bread
     *
     * @return $this
     */
    public function addBread($bread)
    {
        $this->params[self::PARAM_NAME_BREAD][] = $bread;

        return $this;
    }

    /**
     * @param array $aBread
     *
     * @return $this
     */
    public function setBread(array $aBread)
    {
        $this->params[self::PARAM_NAME_BREAD] = $aBread;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getBread()
    {
        if ($this->hasBread()) {
            return $this->params[self::PARAM_NAME_BREAD];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasBread()
    {
        return (isset($this->params[self::PARAM_NAME_BREAD]) && is_array($this->params[self::PARAM_NAME_BREAD]));
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

    /**
     * @param string $sKey
     *
     * @return bool
     */
    public function hasFlash($sKey)
    {
        return \Yii::$app->getSession()->hasFlash($sKey);
    }

    /**
     * @param string $sKey
     *
     * @return string|null
     */
    public function getFlash($sKey)
    {
        return \Yii::$app->getSession()->getFlash($sKey);
    }

    /**
     * @return \yii\console\Controller|\yii\web\Controller
     */
    public function getController()
    {
        return \Yii::$app->controller;
    }
}