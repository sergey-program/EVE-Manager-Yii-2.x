<?php

namespace app\components;

use app\models\api\account\Character;
use yii\web\View;

/**
 * Class ViewExtended
 *
 * @package app\components
 * @property Character|null $character
 */
class ViewExtended extends View
{
    private $character;

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
     * @param array $bread
     *
     * @return $this
     */
    public function setBreads(array $bread)
    {
        $this->params[self::PARAM_NAME_BREAD] = $bread;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getBreads()
    {
        if ($this->hasBreads()) {
            return $this->params[self::PARAM_NAME_BREAD];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasBreads()
    {
        return (isset($this->params[self::PARAM_NAME_BREAD]) && is_array($this->params[self::PARAM_NAME_BREAD]));
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function setFlash($key, $value)
    {
        \Yii::$app->session->setFlash($key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasFlash($key)
    {
        return \Yii::$app->session->hasFlash($key);
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function getFlash($key)
    {
        return \Yii::$app->session->getFlash($key);
    }

    /**
     * @param Character $character
     *
     * @return $this
     */
    public function setCharacter(Character $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * @return Character|null
     */
    public function getCharacter()
    {
        return $this->character;
    }

}