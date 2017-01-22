<?php

namespace app\components;

use yii\web\View;

/**
 * Class ViewExtended
 *
 * @package app\components
 */
class ViewExtended extends View
{
    /** Variable names in $this->params array. */
    const VN_BREAD = 'bread';
    const VN_PT = 'page_title';
    const VN_PD = 'page_description';

    /**
     * Set default page title.
     */
    public function init()
    {
        parent::init();

        $this->setPageTitle(\Yii::$app->name);
    }

    /**
     * @param string $pageTitle
     *
     * @return $this
     */
    public function setPageTitle($pageTitle)
    {
        $this->params[self::VN_PT] = $pageTitle;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPageTitle()
    {
        return isset($this->params[self::VN_PT]) ? $this->params[self::VN_PT] : null;
    }

    /**
     * @param string $pageDescription
     *
     * @return $this
     */
    public function setPageDescription($pageDescription)
    {
        $this->params[self::VN_PD] = $pageDescription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPageDescription()
    {
        return isset($this->params[self::VN_PD]) ? $this->params[self::VN_PD] : null;
    }

    /**
     * @param string|array $bread
     *
     * @return $this
     */
    public function addBread($bread)
    {
        $this->params[self::VN_BREAD][] = $bread;

        return $this;
    }

    /**
     * @param array $bread
     *
     * @return $this
     */
    public function setBreads(array $bread)
    {
        $this->params[self::VN_BREAD] = $bread;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getBreads()
    {
        return ($this->hasBreads()) ? $this->params[self::VN_BREAD] : null;
    }

    /**
     * @return bool
     */
    public function hasBreads()
    {
        return (isset($this->params[self::VN_BREAD]) && is_array($this->params[self::VN_BREAD]));
    }
}