<?php

abstract class cAbstract
{
    /**
     * @param string $sKey
     * @param string $sValue
     *
     * @return void
     */
    public function setFlash($sKey, $sValue)
    {
        Yii::app()->user->setFlash($sKey, $sValue);
    }
}