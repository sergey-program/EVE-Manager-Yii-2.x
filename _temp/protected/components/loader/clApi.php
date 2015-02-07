<?php

class clApi
{
    /**
     * @return array
     */
    public static function loadAll()
    {
        $aReturn = array();

        foreach (Api::model()->findAll() as $oApi) {
            $aReturn[] = new cApi($oApi);
        }

        return $aReturn;
    }
}